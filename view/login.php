<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>AJAX聊天室</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>

    <body>
        <p id="login">
            <div class="card" style="width: 25rem; padding: 20px; margin: auto">
            <span style="text-align:center"><p1>LOGIN</p1></span>
                <form action="chatindex.php" name="form1" method="post">
                    <div class="form-group">
                        <label>用户名:</label>
                        <input type="text" required="required" class="form-control" name="username" placeholder="用户名">
                    </div>
                    <div class="form-group">
                        <label>密码:</label>
                        <input type="password" required="required" class="form-control" placeholder="密码" name="password"/>
                    </div>

                    <button type="submit" class="btn btn-primary">登录</button>
                </form>
            </div>
        </p>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                crossorigin="anonymous"></script>
    </body>
</html>