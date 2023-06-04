function Captcha(){
    let response = fetch('https://swe.gdr00.it/api/v1/generate', {
    method: 'GET',
    headers: {
        Authentication: '4|Ag86uaVLYDvQP306TAA0TXawe68LPTkTtVhN8cff'
    }
    });
    let data = response.json();

    let images_array = [];
    let images_containers = document.getElementsByClassName("img-container");
    let images_src = images_containers.getElementsByTagName('img');

    for(let i = 0;i < 10;i++){
        images_array.push(data["data"]["captchaImg"]["images"][i]["src"]);
        images_src[i].src = images_array[i];
    }

    let pow_array = [];
    for(let i = 0; i < 3;i++){
        pow_array.push(data["data"]["proofOfWorkDetails"]["fixedStrings"][i]);
    }

    sessionStorage.clear();

    sessionStorage.setItem('solution',data["data"]["captchaImg"]["solution"]);
    sessionStorage.setItem('keyNumber', data["data"]["captchaImg"]["keyNumber"]);
    sessionStorage.setItem('difficulty', data["data"]["proofOfWorkDetails"]["difficulty"]);

    Pow();

}

function Response(){
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    let images_array = [];
    

}

