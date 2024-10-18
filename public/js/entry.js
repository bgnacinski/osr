var parent_table = document.getElementById("bill_contents_table");
var bill_input = document.getElementById("bill_contents");

function refreshTable(){
    let input_val = bill_input.value;
    if(input_val != ""){
        let buffer = input_val.split(";");
        buffer.pop();

        let product_name = buffer.split(",")[0];
        let quantity = buffer.split(",")[1];

        data.forEach((product) => {
            if(product.name == product_name){
                let product_name_el = document.createElement("td");
                product_name_el.textContent = product_name;
                tr.appendChild(product_name_el);

                let description = document.createElement("td");
                description.textContent = product.description
                tr.appendChild(description);

                let amount = document.createElement("td");
                amount.textContent = product.amount;
                tr.appendChild(amount);

                let quantity_el = document.createElement("td");
                quantity_el.textContent = quantity;
                tr.appendChild(quantity_el);

                let sum_netto = document.createElement("td");
                sum_netto.textContent = Math.round(product.amount * parseInt(quantity) * 100) / 100;//round to 2 decimals
                tr.appendChild(sum_netto);

                let vat = document.createElement("td");
                vat.textContent = product.vat;
                tr.appendChild(vat);

                let sum_brutto = document.createElement("td");
                let brutto_value = ((product.amount * parseInt(quantity)) * multiplier);
                sum_brutto.textContent = Math.round(brutto_value * 100) / 100;
                tr.appendChild(sum_brutto);

                let delete_button = document.createElement("td");
                delete_button.innerHTML = `<a onclick='deleteEntry("` + product_name + "," + quantity +  "." + tr.id + `")'>
                    <span class="material-symbols-outlined delete-icon">delete</span>
                </a>`;
                tr.appendChild(delete_button);
            }
        });
    }
}

function addEntry(){
    let product_name = document.getElementById("name").value;
    let description = document.getElementById("description").value;
    let price = document.getElementById("price").value;
    let quantity = document.getElementById("quantity").value;

    let tr = document.createElement("tr");
    tr.id = product_name + quantity + "_row";

    // row data
    let data_array = {
        "product_name": product_name,
        "description": description,
        "amount": price,
        "quantity": quantity
    };

    parent_table.innerHTML += `
    <tr id="${product_name}${quantity}_row">
        <td>${product_name}</td>
        <td>${description}</td>
        <td>${price} PLN</td>
        <td>${quantity}</td>
        <td>${price * quantity} PLN</td>
        <td>
            <a onclick='deleteEntry("${product_name},${quantity}.${product_name}${quantity}_row")'>
                <span class="material-symbols-outlined delete-icon">delete</span>
            </a>
        </td>
    </tr>`;

    bill_input.value += product_name + "," + quantity + ";";
}

function deleteEntry(input){
    let input_arr = input.split(".");
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