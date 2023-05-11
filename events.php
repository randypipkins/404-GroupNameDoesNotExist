<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add event</title>
   <link rel="stylesheet" href="style.css" />
</head>

<body>
    <!-- Side-Nav -->
  <div class="side-nav active-nav" id="sidebar">
    <ul class="nav flex-column text-white w-100">
      <h3 class="h3 text-white my-2" id="h3"> I Do Crew
	  </h3>
    <li href="" class="nav-link">
        <i class="bx bxs-dashboard text-white"></i>
        <a href="eventOrg.php" class="btn btn-danger"><span class="mx-2 text-white">Dashboard</span></a>
      </li>
      <li href="" class="nav-link">
        <i class="bx bxs-dashboard text-white"></i>
        <a href="events.php" class="btn btn-danger"><span class="mx-2 text-white">Events</span></a>
      </li>
      <li href="" class="nav-link">
        <i class="bx bx-user-check text-white"></i>
        <a href="logout.php" class="btn btn-danger"><span class="mx-2 text-white">Logout</span></a>
      </li>
    </ul>
  </div>


    <div class="p-1 my-container active-cont">
        
        <!-- Top Nav -->
        <header>
            <h1>Events</h1>
            <p class="description-p">Add event title, description, start date (d/m/yr), start time(hh:mm AM/PM), end
                day(d/m/yr), end time(hh:mm AM/PM), location, capacity, event type(ex: Bridal Shower)</p>
            <form id="new-task-form">
                <input type="text" name="new-task-input" id="new-task-input" placeholder="Enter Event" />
                <input type="submit" id="new-task-submit" value="Add event" />
            </form>
        </header>
        <main>
            <section class="task-list">
                <div class="tabs">
                    <h2>Event title ||</h2>
                    <h2>description ||</h2>
                    <h2>start date || </h2>
                    <h2>start time ||</h2>
                    <h2>end date ||</h2>
                    <h2>end time ||</h2>
                    <h2>location ||</h2>
                    <h2>capacity ||</h2>
                    <h2>event type ||</h2>
                </div>
                <div id="tasks"></div>
            </section>
        </main>
    </div>


    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>