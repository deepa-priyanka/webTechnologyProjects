// Initialize items array to store added items
let items = [];

// Function to add an item to the table
function addItem() {
    // Get input values
    let item = document.getElementById('item').value;
    let quantity = parseInt(document.getElementById('quantity').value);
    
    // Create new item object and add it to the items array
    let newItem = {
        item: item,
        quantity: quantity,
        cost: calculateCost(item, quantity)
    };
    items.push(newItem);
    
    // Clear input fields
    document.getElementById('item').value = '';
    document.getElementById('quantity').value = '';
    
    // Update table and total cost
    updateTable();
    updateTotalCost();
}

// Function to calculate the cost of an item based on its name and quantity
function calculateCost(item, quantity) {
    // This is where you would put your own calculation logic
    // For this example, we will just return a random cost between 1 and 10
    return Math.floor(Math.random() * 10) + 1;
}

// Function to update the table with the current items
function updateTable() {
    // Get the table body element and clear any existing rows
    let tableBody = document.querySelector('#items tbody');
    tableBody.innerHTML = '';
    
    // Loop through the items array and add each item to the table
    items.forEach((item) => {
        let row = tableBody.insertRow();
        let nameCell = row.insertCell(0);
        let quantityCell = row.insertCell(1);
        let costCell = row.insertCell(2);
        
        nameCell.innerText = item.item;
        quantityCell.innerText = item.quantity;
        costCell.innerText = item.cost;
    });
}

// Function to update the total cost based on the current items
function updateTotalCost() {
    // Get the total cost element and calculate the total cost
    let totalCost = 0;
    items.forEach((item) => {
        totalCost += item.cost * item.quantity;
    });
    
    // Update the total cost element
    document.getElementById('total-cost').innerText = totalCost;
}
