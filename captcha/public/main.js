function Captcha(){
    let data = fetch('/api/v1/generate', {
    method: 'GET',
    headers: {
        Authentication: 'Bearer {4|Ag86uaVLYDvQP306TAA0TXawe68LPTkTtVhN8cff}'
    }
    }).then(function(response) {
        return response.json();
    });
    
   
    let images_array = [];
    let images_containers = document.getElementsByClassName("img-container");
    let images_src = images_containers.getElementsByTagName('img');

    for(let i = 0;i < 10;i++){
        images_array.push(data["data"]["captchaImg"]["images"][i]["src"]);
        images_src[i].src = images_array[i];
    }

    let fs_array = [];
    for(let i = 0; i < 3;i++){
        fs_array.push(data["data"]["proofOfWorkDetails"]["fixedStrings"][i]);
    }

    sessionStorage.clear();

    sessionStorage.setItem('solution',data["data"]["captchaImg"]["solution"]);
    sessionStorage.setItem('keyNumber',data["data"]["captchaImg"]["keyNumber"]);
    sessionStorage.setItem('difficulty',data["data"]["proofOfWorkDetails"]["difficulty"]);
    sessionStorage.setItem('fixedStrings',fs_array);

    Pow();

}

function Response(){
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    let images_array = [];
    for(let i=0; i < 10; i++){
        images_array.push(document.getElementById("img"+i).checked);
    }

    var dict_json = {
        "response" : images_array,
        "solution" : sessionStorage.getItem('solution'),
        "keyNumber" : sessionStorage.getItem('keyNumber'),
        "fixedStrings" : sessionStorage.getItem('fixedStrings'),
        "nonces" : sessionStorage.getItem('nonces')
    };

    var json_response = JSON.stringify(dict_json);

    fetch("/api/v1/verify",{
        method: "POST",
        headers:{
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
        },
        body: json_response
    }).then(res => res.json())
      .catch(function(error){
        console.log('Request failed', error);
      });

}

