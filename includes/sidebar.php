<?php if($_SESSION["user"]['role'] == 'admin'){ ?>
<div class="sidebar">
    <h2>Library Management</h2>

    <ul>
      <li><a href="/adashboard">Dashboard</a></li>
       <li><a href="/books">Books</a></li>
        <li><a href="/students">Students</a></li>
        <li><a href="/issues">Issues</a></li>
        <li><a href="/add_users">Add User</a></li>
    </ul>
</div>
<?php }else{ ?>
<div class="sidebar">

<h2>Library Management</h2>

<ul>
<li><a href="/dashboard">Dashboard</a></li>
<li><a href="/books">Books</a></li>
<li><a href="/due_book">Issued</a></li>
<li><a href="/return">Returned</a></li>
</ul>
</div>
<?php } ?>