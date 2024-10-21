var parent_table = document.getElementById("bill_contents_table");
var bill_input = document.getElementById("bill_contents");

function isFloat(n){
    return Number(n) === n && n % 1 !== 0;
}

function addEntry(){
    let product_name = document.getElementById("name").value;
    let description = document.getElementById("description").value;
    let price = parseFloat(document.getElementById("price").value);
    let quantity = parseInt(document.getElementById("quantity").value);
    let total = Math.round((price * quantity) * 100) / 100;

    if(!Number.isInteger(price) || !Number.isInteger(quantity)) {
        if(!isFloat(price) || !Number.isInteger(quantity)){
            return;
        }
    }

    let tr = document.createElement("tr");
    tr.id = product_name + quantity + "_row";

    parent_table.innerHTML += `
    <tr id="${product_name}${quantity}_row">
        <td>${product_name}</td>
        <td>${description}</td>
        <td>${price} PLN</td>
        <td>${quantity}</td>
        <td>${total} PLN</td>
        <td>
            <a onclick='deleteEntry("${product_name},${description},${quantity},${price};${product_name}${quantity}_row")'>
                <span class="material-symbols-outlined delete-icon">delete</span>
            </a>
        </td>`;

    bill_input.value += `${product_name},${description},${quantity},${price};`;

    // clear inputs
    document.getElementById("name").value = "";
    document.getElementById("description").value = "";
    document.getElementById("price").value = "";
    document.getElementById("quantity").value = "";
}

function deleteEntry(input){
    let input_arr = input.split(";");
    let row_identificator = input_arr[0];
    let table_row_id = input_arr[1];

    let buffer = bill_input.value.split(";");
    buffer.pop();

    for(let i = 0; i <= buffer.length-1; i++){
        if(row_identificator == buffer[i]){
            buffer.splice(i, 1);
            break;
        }
    }

    let input_data = "";

    buffer.forEach((element) => {
        input_data += element + ";"
    });

    document.getElementById(table_row_id).remove();
    bill_input.value = input_data;
}

function getProductByName(name) {
    for(let i = 0; i < data.length; i++){
        if(data[i].name == name){
            return data[i];
        }
    }
}

document.getElementById("name")
    .addEventListener("input", function(event){
        if(event.inputType == "insertReplacementText" || event.inputType == null) {
            let product = getProductByName(event.target.value);

            document.getElementById("description").value = product.description;
            document.getElementById("price").value = product.amount;
        }
    }
);