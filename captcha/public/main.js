function Captcha(){
    let response = fetch('htpps://swe.gdr00.it/api/v1/generate', {
    method: 'GET',
    headers: {
        Authentication: '4|Ag86uaVLYDvQP306TAA0TXawe68LPTkTtVhN8cff'
    }
    });
    let data = response.json();

    let images_array = [];
    for(let i = 0;i < 10;i++){
        images_array.push(data["data"]["captchaImg"]["images"][i]["src"]);
    }

    let pow__array = [];
    for(let i = 0; i < 3;i++){
        pow_array.push(data["data"]["proofOfWorkDetails"]["fixedStrings"][i]);
    }

    sessionStorage.clear();
    
    sessionStorage.setItem('solution',data["data"]["captchaImg"]["solution"]);
    sessionStorage.setItem('keyNumber', data["data"]["captchaImg"]["keyNumber"]);
    sessionStorage.setItem('difficulty', data["data"]["proofOfWorkDetails"]["difficulty"]);


    pow();

}


