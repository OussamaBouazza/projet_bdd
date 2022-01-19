let nbItem = 1;

let addField = () =>{
    nbItem++;

    let formInputs = document.getElementById("item-inputs");


    const labelItemName = document.createElement("label");
    labelItemName.setAttribute("for", "nom-item-"+nbItem);
    labelItemName.innerHTML = "<b>Nom de l'article :</b>";

    const inputItemName = document.createElement("input");
    inputItemName.setAttribute("type","text");
    inputItemName.setAttribute("placeholder","Entrez le nom de l'objet à commander");
    inputItemName.setAttribute("name","name_item_"+nbItem);
    inputItemName.required = true;
    

    const labelQuantity = document.createElement("label");
    labelQuantity.setAttribute("for", "quantite-"+nbItem);
    labelQuantity.innerHTML = "<b>Quantité :</b>";

    const inputQuantity = document.createElement("input");
    inputQuantity.setAttribute("type","number");
    inputQuantity.setAttribute("min","1");
    inputQuantity.setAttribute("placeholder","Entrez la quantité voulue");
    inputQuantity.setAttribute("name","quantite_"+nbItem);
    inputQuantity.required = true;

    const divWrapper = document.createElement("div");
    divWrapper.setAttribute("class","field");
     
    divWrapper.append(labelItemName);
    divWrapper.append(inputItemName);
    divWrapper.append(labelQuantity);
    divWrapper.append(inputQuantity); 

    formInputs.appendChild(divWrapper);
 

}