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
                // Send the data to the server
                const data = new FormData();
                data.append("title", newRow.cells[0].innerHTML);
                data.append("event_type", newRow.cells[1].innerHTML);
                data.append("description", newRow.cells[2].innerHTML);
                data.append("date", newRow.cells[3].innerHTML);
                data.append("start_time", newRow.cells[4].innerHTML);
                data.append("end_time", newRow.cells[5].innerHTML);
                data.append("location", newRow.cells[6].innerHTML);
                data.append("capacity", newRow.cells[7].innerHTML);
        
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            alert("Event added successfully!");
                        } else {
                            alert("Error adding event: " + xhr.responseText);
                        }
                    }
                };
        
                xhr.open("POST", "add_event.php", true);
                xhr.send(data);
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
    if (table.rows.length > 1 && rIndex !== undefined) {
      const eventId = table.rows[rIndex].cells[0].innerHTML;
  
      // Send the event ID to the server for deletion
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            alert("Event deleted successfully!");
            table.deleteRow(rIndex);
            rIndex = undefined; // Reset the row index
          } else {
            alert("Error deleting event: " + xhr.responseText);
          }
        }
      };
  
      xhr.open("POST", "delete_event.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("event_id=" + encodeURIComponent(eventId));
    }
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