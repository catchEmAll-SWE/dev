let running = 0;
let nonces = [];

function loading(){
    document.getElementById("loading").style.visibility = "visible";
}

function stopLoading(){
    document.getElementById("loading").style.visibility = "hidden";
}

function verifyCredential(){
    var username = document.getElementById("username").value;
    var psw = document.getElementById("password").value;
    if(username == "CatchEmAll" && psw == "captcha")
        return true;
    else
        return false;
}

async function getCaptcha(){
    if(verifyCredential()){
        document.getElementById("form2").reset();
        document.getElementById("error").innerHTML = "";
        document.getElementById("generate").style.display = "hidden"; 
        document.getElementById("generate").innerHTML = "Rigenera captcha"; 
        document.querySelector(".pow").setAttribute("style","width:0%");
        document.querySelector(".percentage").innerHTML = "0%";
        loading();
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
        stopLoading();
        document.getElementById("progress-bar").style.visibility = "visible";
        document.getElementById("resetForm").style.visibility = "visible";
        document.getElementById("submit").style.visibility = "visible";
        document.getElementById("captcha-images").style.display = "grid";
        
        
        console.log(data);
        document.getElementById("target-class").textContent=data["data"]["captchaImg"]["target"];
        let images_array = [];
        let images = document.querySelectorAll("img");
        
        
        for(let i = 0;i < 10;i++){
            images_array.push(data["data"]["captchaImg"]["images"][i]["src"]);
            images[i].src = "data:image/png;base64," + images_array[i];
        }
        let fs_array = [];
        for(let i = 0; i < 3;i++){
            fs_array.push(data["data"]["proofOfWorkDetails"]["fixedStrings"][i]);
        }
        
        sessionStorage.clear();
        
        sessionStorage.setItem('solution',data["data"]["captchaImg"]["solution"]);
        sessionStorage.setItem('keyNumber',data["data"]["captchaImg"]["keyNumber"]);
        sessionStorage.setItem('difficulty',data["data"]["proofOfWorkDetails"]["difficulty"]);
        sessionStorage.setItem("fixedStrings", JSON.stringify(fs_array));
        pow(); 
          
    }else{
        document.getElementById("error").innerHTML = "Credenziali non valide";  
    }
}

function pow(){
    console.log("Starting pow");
    if (typeof(Worker) !== "undefined") {
        console.log("Starting pow's workers");
        content = JSON.parse(sessionStorage.getItem("fixedStrings"));
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
    --running;
    console.log("Worker "+e.data[1]+" is done, hashcode found: "+e.data[0]);
    nonces[e.data[1]] = e.data[0].toString();
    var progress = 33*(3-running);
    document.querySelector(".pow").style.width = progress+1 + "%";
    document.querySelector(".percentage").innerHTML = progress+1 + "%";
    if(running === 0){
        console.log("All workers complete");
        document.getElementById("generate").style.visibility = "visible"; 
    }
    sessionStorage.setItem("nonces", JSON.stringify(nonces));
}

async function verify(){
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
        "http://localhost/SWE/dev/captcha/public/api/v1/verify"
        //"https://swe.gdr00.it/api/v1/verify"
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
            
    result = await fetch(url, {
        method: "post",
        headers,
        body: JSON.stringify(body),
    })
    console.log(await result);
    });
}



