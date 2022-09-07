<?php


?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
           $('#SubmitFilter').click(function () {
               const url = 'filmsFilter.php';
               let rowCount = $('#tableResults tbody  tr').length;
               if (rowCount >= 1) {
                   console.log('true');
                   $('#tableResults tbody tr > td').remove();
               }
               let filmTitle = $('#FilmTitle').val();
               let filmRunningTimeStartInterval = $('#FilmRunningTimeStartInterval').val();
               let filmRunningTimeEndInterval = $('#FilmRunningTimeEndInterval').val();
               let queryString = "?filmTitle=" + filmTitle + "&filmRunningTimeStartInterval=" +
                   filmRunningTimeStartInterval + "&filmRunningTimeEndInterval=" + filmRunningTimeEndInterval;
               $.ajax({
                    type: 'GET',
                    url: url + queryString,
                    datatype: 'json',
                    success: function (result) {
                        console.log(result);
                        let tableData = "";
                        $.each(JSON.parse(result), function (index, data) {
                           tableData += "<tr>";
                           tableData += '<td><img src="'+data.image+'" alt="Image" width="150" height="150"></td>';
                           tableData += "<td>" + data.title +  "</td>";
                           tableData += "<td>" + data.running_time + "</td>";
                           tableData += "<td>" + data.description + "</td>";
                           tableData += "</tr>";
                        });
                        $('#tableResults').append(tableData);
                    },
                   error: function(e){
                       console.log(e);
                   }
               });
           })
        });
    </script>
    <title>Film filter input</title>
</head>
<body>
<div class="container">
    <div class="mb-3">
        <label for="FilmTitle" class="form-label">Email address</label>
        <input type="email" class="form-control" id="FilmTitle" placeholder="Example">
    </div>
    <div class="mb-3">
        <label for="FilmRunningTime1" class="form-label">Film running time start interval</label>
        <input type="number" class="form-control" id="FilmRunningTimeStartInterval" placeholder="90" min="60">
    </div>
    <div class="mb-3">
        <label for="FilmRunningTime2" class="form-label">Film running time end interval</label>
        <input type="number" class="form-control" id="FilmRunningTimeEndInterval" placeholder="120" max="200">
    </div>
    <button type="submit" class="btn btn-success" id="SubmitFilter">Submit</button>
    <div id="Results">
        <table class="table table-responsive" id="tableResults">
            <thead>
                <th>Image</th>
                <th>Title</th>
                <th>Running time (min)</th>
                <th>Description</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>