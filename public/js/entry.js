var parent_table = document.getElementById("bill_contents_table");
var bill_input = document.getElementById("bill_contents");

var tax_rate = document.getElementById("tax_rate").value;

function addEntry(){
    let multiplier = (100 + parseInt(tax_rate)) / 100;

    let product_name = document.getElementById("product_name").value;
    let quantity = document.getElementById("quantity").value;

    let tr = document.createElement("tr")

    // row data
    let data_array = {
        "product_name": product_name,
        "description": "",
        "amount": 0,
        "quantity": quantity
    };

    bill_input.value += product_name + "," + quantity + ";";

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
            sum_netto.textContent = product.amount * parseInt(quantity);
            tr.appendChild(sum_netto);

            let sum_brutto = document.createElement("td");
            let brutto_value = ((product.amount * parseInt(quantity)) * multiplier);
            sum_brutto.textContent = Math.round(brutto_value * 100) / 100;
            tr.appendChild(sum_brutto);
        }
    });

    parent_table.appendChild(tr);
}