//functionality for the events
document.querySelector(".add-btn").addEventListener("click", function(){
    //retrieve the form values
    var title = document.getElementById("input-0").value;
    var location = document.getElementById("input-1").value;
    var date = document.getElementById("input-2").value;
    var start_time = document.getElementById("input-3").value;
    var end_time = document.getElementById("input-4").value;
    var capacity = document.getElementById("input-5").value;
    var description = document.getElementById("input-6").value;

    //create new FormData object
    var formData = new FormData();
    formData.append("title", title);
    formData.append("location", location);
    formData.append("date", date);
    formData.append("start_time", start_time);
    formData.append("end_time", end_time);
    formData.append("capacity", capacity);
    formData.append("description", description);

    //create new XMLHttpRequest
    var xhr = new XMLHttpRequest();

    //open a POST request to the event_handler.php file
    xhr.open("POST", "event_handler.php", true);

    //set the onload event handler
    xhr.onload = function(){
        if(xhr.status === 200){
            //request was successful, handle the response
            console.log(xhr.responseText);
            //reset the form
            document.getElementById("input-0").value = "";
            document.getElementById("input-1").value = "";
            document.getElementById("input-2").value = "";
            document.getElementById("input-3").value = "";
            document.getElementById("input-4").value = "";
            document.getElementById("input-5").value = "";
            document.getElementById("input-6").value = "";
        } else{
            //request failed, handle the error
            console.error("Request failed. Status: " + xhr.status);
        }
    };

    //send the form data
    xhr.send(formData);
});