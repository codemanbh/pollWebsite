let i = 2;
let counter = 2

function validateForm(){
    return true;
}

function deleteOption(opNum){
    if(counter==2){
        alert("you can't have less then 2 options");
        return;
    }
    document.getElementById(`o${opNum}Container`).innerHTML = '';
    counter--;
    let j = 1;   
    Array.from(document.getElementsByClassName('opLabel')).forEach(element => {
        element.innerHTML = `Option ${j}`;
        j++;    
    });
    return;
}

function addNewOption(){
    if (counter==10){
        alert("you can't add more then 10 options");
        return;
    }
    i++;
    counter++;
    let optionPlace = Array.from( document.getElementsByClassName('newOption'));
    
    let lastOptionPlace = optionPlace[optionPlace.length -1]
    
    let newOption = `<div id="o${i}Container">
            <label class='opLabel' for="o${i}">Option ${counter}</label>
            <input type="text" id="o${i}" name="options[]" required>
            <button type='button' class='btn' onclick="deleteOption(${i})">Delete</button>
            <br>
        </div>
        <span class="newOption"></span>
        `;
    lastOptionPlace.innerHTML = newOption;
    return;
}
