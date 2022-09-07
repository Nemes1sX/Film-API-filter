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
               let filmTitle = $('#FilmTitle').val();
               let filmRunningTime1 = $('#FilmRunningTime1').val();
               let filmRunningTime2 = $('#FilmRunningTime2').val();
               let queryString = "?filmtitle=" + filmTitle + "&runningtime1=" + filmRunningTime2 + "&runningtime2=" + filmRunningTime2;
               console.log([filmTitle, filmRunningTime1, filmRunningTime2]);
               $.ajax({
                    type: 'GET',
                    url: url,
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
        <label for="FilmRunningTime1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="FilmRunningTime1" placeholder="90">
    </div>
    <div class="mb-3">
        <label for="FilmRunningTime2" class="form-label">Email address</label>
        <input type="email" class="form-control" id="FilmRunningTime2" placeholder="120">
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