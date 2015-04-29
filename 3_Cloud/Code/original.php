<!doctype html>
<!--
    ==========================================================================
     Michael Meding
     2015-04-7
    ==========================================================================
-->
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cloud Test</title>

    <!-- Library Style Sheets -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="http://bootswatch.com/flatly/bootstrap.css">
    <!-- Library Scripts -->
    <script src="app/js/users.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.js"></script>

    <!--CDN's-->
    <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>-->
    <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.12/angular.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.12/angular-sanitize.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.12.0/ui-bootstrap.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.12.0/ui-bootstrap-tpls.js"></script>-->

</head>

<body>

<div class="container">
    <div class="jumbotron slideInDown animated">
        <h1>Software Engineering</h1>

        <p>A quick cloud example page</p>
    </div>
    <hr>
    <h2 class="slideInRight animated"> Database Schema </h2>

    <!--USERS TABLE-->
    <h3 class="slideInRight animated">Add New User</h3>

    <div class="row">
        <div class="col-lg-6">
            <form action="app/php/users.php" method="post" class="slideInRight animated" id="newUserForm">
                <div class="form-group">
                    <label for="newUsername">Username</label>
                    <input id="newUsername" type="text" class="form-control" placeholder="Enter username" autofocus/>
                </div>

                <div class="form-group">
                    <label for="newPassword">Password</label>
                    <input id="newPassword" type="password" class="form-control" placeholder="Enter password"/>
                </div>
                <div class="form-group">
                    <label for="newPermissions">Permissions</label>
                    <input id="newPermissions" type="password" class="form-control" placeholder="Enter password"/>
                </div>
                <div class="form-group">
                    <label for="newEmail">Email</label>
                    <input id="newEmail" type="password" class="form-control" placeholder="Enter password"/>
                </div>
                <div class="form-group">
                    <label for="newComment">Comment</label>
                    <input id="newComment" type="password" class="form-control" placeholder="Enter password"/>
                </div>

                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>

    <h3 class="slideInRight animated"> Users Table </h3>
    <table class="table table-hover slideInLeft animated">
        <thead>
        <th>username</th>
        <th>password</th>
        <th>permissions</th>
        <th>email</th>
        <th>comment</th>
        </thead>
        <tbody>
        <td>mike</td>
        <td>*****</td>
        <td>RW</td>
        <td>mikeymeding@gmail.com</td>
        <td>First User</td>
        </tbody>
    </table>

    <h3 class="slideInRight animated">App Settings</h3>
    <table class="table table-hover slideInLeft animated">
        <thead>
        <th>color</th>
        <th>type</th>
        <th>delay</th>
        <th>settings</th>
        </thead>
        <tbody>
        <td>Black</td>
        <td>QWERTY</td>
        <td>10ms</td>
        <td>(JSON settings object)</td>
        </tbody>
    </table>

    <h3 class="slideInRight animated">Keybindings</h3>
    <table class="table table-hover slideInLeft animated">
        <thead>
        <th>Sequence</th>
        <th>Action</th>
        </thead>
        <tbody>
        <td>Ctl-x</td>
        <td>EXPLODE</td>
        </tbody>
    </table>
    <!--The little copyright footer-->
    <footer class="text-center">
        <p>Copyright &copy; 2015 Software Engineering I</p>
    </footer>
</div>


</body>
</html>
