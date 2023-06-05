let running = 0;
let nonces = [];
async function getCaptcha(){
    const url = new URL(
        "http://localhost/SWE/dev/captcha/public/api/v1/generate"
        //"https://swe.gdr00.it/api/v1/generate"
    );
    const headers = {
        "Authorization": "Bearer 4|Ag86uaVLYDvQP306TAA0TXawe68LPTkTtVhN8cff",
        "Content-Type": "application/json",
        "Accept": "application/json",
    };

    let response = await fetch(url, {
        method: "GET",
        headers,
    });
    data = await response.json();
    console.log(data);


    let images_array = [];
    let images = document.querySelectorAll("img");


    for(let i = 0;i < 10;i++){
        images_array.push(data["data"]["captchaImg"]["images"][i]["src"]);
        images[i].src = "data:image/png;base64," + images_array[i];
    }
    let fs_array = [];
    let fixedStrings = document.getElementsByName('fixed_strings[]');
    for(let i = 0; i < 3;i++){
        fs_array.push(data["data"]["proofOfWorkDetails"]["fixedStrings"][i]);
        fixedStrings[i].value = data["data"]["proofOfWorkDetails"]["fixedStrings"][i];
    }

    sessionStorage.clear();

    sessionStorage.setItem('solution',data["data"]["captchaImg"]["solution"]);
    sessionStorage.setItem('keyNumber',data["data"]["captchaImg"]["keyNumber"]);
    sessionStorage.setItem('difficulty',data["data"]["proofOfWorkDetails"]["difficulty"]);
    sessionStorage.setItem("fixedStrings", JSON.stringify(fs_array));


    Pow();

}

function Pow(){
    console.log("Starting pow");
    if (typeof(Worker) !== "undefined") {
        console.log("Starting pow's workers");
        content = sessionStorage.getItem('fixedStrings');
        difficulty = sessionStorage.getItem('difficulty');
        //create 3 workers
        for(let i=0; i<3; ++i){
            worker = new Worker("web-worker.js");
            worker.onmessage = workerDone;
            worker.postMessage([content[i], difficulty, i]);
            running++;
        }

    } else {
        // Sorry! No Web Worker support..
        console.log("No Web Worker support");
    }
}

function workerDone(e){
    let nonces = document.getElementsByName('nonces[]');
    --running;
    console.log("Worker "+e.data[1]+" is done, hashcode found: "+e.data[0]);
    nonces[e.data[1]] = e.data[0].toString();
    if(running === 0){
        console.log("All workers complete");
    }
    sessionStorage.setItem("nonces", JSON.stringify(nonces));}


async function Verify(){
    const form = document.getElementById('form');

    form.addEventListener('submit', async function(e) {
    e.preventDefault();
    let response = "";
    let fixedStrings = JSON.parse(sessionStorage.getItem("fixedStrings"));
    let nonces = JSON.parse(sessionStorage.getItem("nonces"));

    for(let i=0; i < 10; i++){
        if(document.getElementById("img"+i).checked){
            response += "1";
        }else{
            response+= "0";
        }
    }
            const url = new URL(
                "https://swe.gdr00.it/api/v1/verify"
            );
                    
            const headers = {
                "Authorization": "Bearer 4|Ag86uaVLYDvQP306TAA0TXawe68LPTkTtVhN8cff",
                "Content-Type": "application/json",
                "Accept": "application/json",
            };
                    
            let body = {
                "response": response,
                "solution": sessionStorage.getItem('solution'),
                "keyNumber": parseInt(sessionStorage.getItem('keyNumber')),
                "fixedStrings": fixedStrings,
                "nonces": nonces
            };
            console.log(JSON.stringify(body));
            
            result = await fetch(url, {
                method: "post",
                headers,
                body: JSON.stringify(body),
            })
            console.log(await result);
            });
}



