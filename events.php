<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <!-- bootstrap 5 css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- BOX ICONS CSS-->
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet">
  <!-- custom css -->
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <!-- Side-Nav -->
  <div class="side-nav active-nav" id="sidebar">
    <ul class="nav flex-column text-white w-100">
      <h3 class="h3 text-white my-2" id="h3"> I Do Crew
	  </h3>
      <li href="" class="nav-link">
        <i class="bx bxs-dashboard text-white"></i>
        <span class="mx-2 text-white">Dashboard</span>
      </li>
      <li href="" class="nav-link">
        <i class="bx bxs-dashboard text-white"></i>
        <span class="mx-2 text-white">Events</span>
      </li>
      <li href="" class="nav-link">
        <i class="bx bx-user-check text-white"></i>
        <span class="mx-2 text-white">Logout</span>
      </li>
    </ul>
  </div>
  <!-- Main Wrapper -->
  <div class="p-1 my-container active-cont">
    <!-- Top Nav -->
    <nav class="navbar top-navbar navbar-light bg-light px-5">
    <a class="btn border-0" id="menu-btn"><i class="bx bx-menu"></i></a>
    </nav>
<!-- Modal -->
    <div class="container mt-3">
        <button type="button" id ="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
          Add Event
        </button>
      </div>
      
      <!-- The Modal -->
      <div class="modal" id="myModal">
        <div class="modal-dialog modal-fullscreen">
          <div class="modal-content">
      
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Add Event</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <script>
              $(function() {
                if(!Modernizr.inputtypes['date']) {
                  $('input[type=date]').datepicker({
                    dateFormat: 'mm-dd-yy'
                  });
                }
              });
            </script>
            <!-- Modal body -->
            <div class="modal-body">
              <form action="" method="POST" class="form">
                <div>
                    <label for="title" class="title"><strong>Enter title of event:</strong></label>
                    <br>
                    <input type="text" class="titletxt" name="Title" id="Title" required>
                    <br>
                    <label for="description" class="description"><strong>Enter description:</strong></label>
                    <br>
                    <textarea class="desc" name="desc" id="desc" rows="4" cols="50">Description...</textarea>
                    <br>
                    <label for="date" name="date"><strong>Select a date:</strong></label>
                    <p><input type="date" name="Date" id="Date" required></p>
                    <label for="Time" name="Time"><strong>Select a start time:</strong></label>
                    <br>
                    <input type="time"class="Time" name="Time" id="Time" required>
                    <br>
                    <label for="Time" name="Time"><strong>Select a end time:</strong></label>
                    <br>
                    <input type="time"class="Time" name="Time" id="Time" required>
                    <br>
                    <label class="form-label" name="address" for="form7Example4"><strong>Enter Address:</strong></label>
                    <br>
                    <input type="text" id="form7Example4" class="form-control" required/>
                    <label class ="capacity" for="capacity" ><strong>Enter capacity:</strong></label>
                    <br>
                    <input type="number" id="Number" max="1000" min="1">
                    <br>
                    <label for="type" class="type"><strong>Choose event type:</strong></label>
                    <br>
                    <select name="Type" class="Type" id="Type">
                        <option value="Bridal Shower">Bridal Shower</option>
                        <option value="Bachelorette Party">Bachelorette Party</option>
                        <option value="Bachelor Party">Bachelor Party</option>
                        <option value="Rehearsal Dinner">Rehearsal Dinner</option>
                        <option value="Wedding Mass">Wedding Mass</option>
                        <option value="Wedding Reception">Wedding Reception</option>
                        <option value="Honeymoon">Honeymoon</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </form>
            </div>
      
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="submit" class="submit">Submit</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
      
          </div>
        </div>
      </div>
      
      
  <!-- bootstrap js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>

</html>