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
function updateEventsTable() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        document.getElementById("eventsTable").getElementsByTagName("tbody")[0].innerHTML = xhr.responseText;
      }
    };
    xhr.open("GET", "get_events.php", true);
    xhr.send();
  }

  // Call the function to initially populate the events table
  updateEventsTable();

  // Set an interval to update the events table every few seconds
  setInterval(updateEventsTable, 5000); // Update every 5 seconds

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

//functionality for the events
document.querySelector(".add-btn").addEventListener("click", function(){
    //retrieve the form values
    var title = document.getElementById("input-0").value;
    var location = document.getElementById("input-6").value;
    var start_time = document.getElementById("input-3").value + " " + document.getElementById("input-4").value;
    var end_time = document.getElementById("input-3").value + " " + document.getElementById("input-5").value;
    var capacity = document.getElementById("input-7");
    var description = document.getElementById("input-2").value;

    //create new FormData object
    var formData = new FormData();
    formData.append("title", title);
    formData.append("location", location);
    formData.append("start_time", start_time);
    formData.append("end_time", end_time);
    formData.append("capacity", capacity);
    formData.append("description", description);

    //create new XMLHttpRequest
    var xhr = new XMLHttpRequest();

    //open a POST request to the event_handler.php file
    xhr.open("POST", "event_handler.php", true);

    //send the form data
    xhr.send(formData);

    //reset the form
    document.getElementById("input-0") = "";
    document.getElementById("input-6") = "";
    document.getElementById("input-3") = "";
    document.getElementById("input-4") = "";
    document.getElementById("input-5") = "";
    document.getElementById("input-7") = "";
    document.getElementById("input-2") = "";
});