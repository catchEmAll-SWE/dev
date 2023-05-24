"""
- Service per ottenere le immagini a partire da un'insieme di classi 
- Interface for the Outlining class
- implementation
"""
import cv2 as cv
import requests as rq
import urllib.request
import numpy as np
import json
import mysql.connector
import base64
import os
import sqlite3

# Strategy pattern

# Algorithm interface
class IOutliningAlgorithm:
    def outline(self, image):
        pass

# Algorithm implementation
class OutliningAlgorithm(IOutliningAlgorithm):
    def outline(self, image):
        gray = cv.cvtColor(image, cv.COLOR_BGR2GRAY)
        bilFilter = cv.bilateralFilter(gray, 11, 17, 17)
        canny = cv.Canny(bilFilter, 20, 200)
        return canny
    
# ---------------------------------------------------------------

# This class provide service for outlining images: 
# crate a new instance of this class with the outlining algorithm and than call the method elaborate to obtain the outlined image
class OutliningService:
    def __init__(self, outliningAlgorithm: IOutliningAlgorithm):
        self.algorithm = outliningAlgorithm
    
    def elaborate(self, image):
        return self.algorithm.outline(image)
    

# This class provide service for retriving (images, id) from unsplash API
class UnsplashService:
    def retriveImage (self, imgClass: str):
        response = rq.get(
          'https://api.unsplash.com/photos/random/?&query={0}&client_id={1}'.format(imgClass, '1CoGBz63unkif-f4iBuOzL4g6o2oP-OMmFoMs7quj24'), allow_redirects=True)
        jsonContent = json.loads(response.content)
        response = urllib.request.urlopen(jsonContent["urls"]["regular"])
        arr = np.asarray(bytearray(response.read()), dtype=np.uint8)
        img = cv.imdecode(arr, -1)
        return img, jsonContent["id"]

# This class provide service for storing images in the database, it provides also a method for checking if an image is already stored (redundancy check)
class ImageDatabaseService:
    local_db_path = "captcha/database/database.sqlite"
    connection = sqlite3.connect(local_db_path)#mysql.connector.connect(host="localhost", user="testuser", password="passwd",database="swe_project")
    cursor = connection.cursor()
    
    @staticmethod
    def insertImage(id, img_class):
        try:
            ImageDatabaseService.cursor.execute("INSERT INTO images (id,class,reliability) VALUES(?,?,?)", (id,img_class,50))
            ImageDatabaseService.connection.commit()
        except mysql.connector.Error as error:
            print("Failed to insert new image into MySQL table {}".format(error))

    @staticmethod
    def isImageRedundant(img_id) -> bool:
        ImageDatabaseService.cursor.execute("SELECT * FROM images where id = ?", (img_id,))
        return (len(ImageDatabaseService.cursor.fetchall())) == 1

# This class provide service for storing images in base64 format in the file system
class StoreImageInBase64Service:

    @staticmethod
    def storeImage(image, img_class, img_id):
        dir = os.path.join("captcha/database/DB_Images/", img_class)
        if not (os.path.exists(dir) or os.path.isdir(dir)):
            os.mkdir(dir)
        try:
            with open(dir + "/" + img_id, "wb") as f:
                f.write(StoreImageInBase64Service.convertImageToBase64(image))
        except:
            print("Error while saving image")


    @staticmethod
    def convertImageToBase64(image):
        return base64.b64encode(cv.imencode('.jpg', image)[1])

def main():
    # list of classes
    classes = ["car", "ball", "umbrella", "book", "laptop"]
    
    unsplash = UnsplashService()
    outlining = OutliningService(OutliningAlgorithm())
    for img_class in classes:
        img, id = unsplash.retriveImage(img_class)
        if(ImageDatabaseService.isImageRedundant(id) == False):
            outliningImage = outlining.elaborate(img)
            StoreImageInBase64Service.storeImage(outliningImage, img_class, id)
            ImageDatabaseService.insertImage(id,img_class)

# ----------------------------------------------------------------------------------------------------------------


# pre requisito: presenza della dir ./CAPTCHA_DB/images
if __name__ == "__main__":
    main()