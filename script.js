// buttons
const addBtn = document.querySelector('button.add-btn');
const editBtn = document.querySelector('button.edit-btn');
const removeBtn = document.querySelector('button.remove-btn');
const modalBtn = document.querySelector('button.display-modal');
const inputModal = document.querySelector('div.tab-2');

let rIndex;
const table = document.getElementById("table");

function checkEmptyInput() {
    const inputs = document.querySelectorAll('input[type="text"]');
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value === "") {
            const fieldName = inputs[i].getAttribute("placeholder");
            alert("Any input cannot be empty");
            return true;
        }
    }
    return false;
}
function addRow() {
    if (!checkEmptyInput()) {
        const newRow = table.insertRow(table.rows.length);
        const cellsCount = table.rows[0].cells.length;

        for (let i = 0; i < cellsCount; i++) {
            const cell = newRow.insertCell(i);
            const input = document.getElementById(`input-${i}`);
            cell.innerHTML = input.value;
        }

        selectedRowToInput();

        // Clear input fields
        const inputs = document.querySelectorAll('input[type="text"]');
        inputs.forEach((input) => {
            input.value = "";
        });
    }
}

function selectedRowToInput() {
    for (let i = 1; i < table.rows.length; i++) {
        table.rows[i].onclick = function () {
            rIndex = this.rowIndex;
            const cells = this.cells;
            for (let j = 0; j < cells.length; j++) {
                const input = document.getElementById(`input-${j}`);
                input.value = cells[j].innerHTML;
            }
        };
    }
}

selectedRowToInput();

function editRow() {
    if (!checkEmptyInput()) {
        const cellsCount = table.rows[0].cells.length;
        for (let i = 0; i < cellsCount; i++) {
            const input = document.getElementById(`input-${i}`);
            table.rows[rIndex].cells[i].innerHTML = input.value;
        }
    }
}

function removeRow() {
    if (table.rows.length > 1) {
        table.deleteRow(rIndex);
        const inputs = document.querySelectorAll('input[type="text"]');
        inputs.forEach((input) => {
            input.value = "";
        });
    }
}

var form = document.getElementById("event-form");
form.addEventListener("submit", function(event) {
    event.preventDefault();
    submitForm();
});

function submitForm() {
    var form = document.getElementById("event-form");
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert("Event added successfully!")
                form.reset();
            } else {
                var response = xhr.responseText;
                alert("Error: " + response);
            }
        }
    };
    xhr.open("POST", "event_handler.php", true);
    xhr.send(formData);
}

// Event Listeners
addBtn.addEventListener("click", () => {
    addRow();
});

editBtn.addEventListener("click", () => {
    editRow();
});

removeBtn.addEventListener("click", () => {
    removeRow();
});

modalBtn.addEventListener("click", () => {
    inputModal.classList.toggle("active");
})