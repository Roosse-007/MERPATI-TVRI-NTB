<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
@yield('title') | MERPATI TVRI NTB
</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


@vite(['resources/css/app.css','resources/js/app.js'])



<style>


body{

    background:#f4f6f9;

}


/* SIDEBAR */

.sidebar{

    width:280px;

    height:100vh;

    position:fixed;

    left:0;

    top:0;

    background:
    linear-gradient(
        180deg,
        #071a52,
        #123b9c,
        #0ea5e9
    );

    color:white;

    overflow-y:auto;

    box-shadow:
    0 0 30px rgba(0,0,0,.3);

    display:flex;

    flex-direction:column;

}



/* LOGO */

.sidebar-logo{

    padding:25px;

    border-bottom:
    1px solid rgba(255,255,255,.2);

}



.sidebar-logo h1{

    font-size:30px;

    font-weight:bold;

    margin:0;

}


.sidebar-logo small{

    color:#bfdbfe;

}





/* MENU */

.sidebar-menu{

    flex:1;

    padding-top:15px;

}



.sidebar a{


    display:flex;

    align-items:center;

    gap:15px;

    color:white;

    text-decoration:none;

    padding:14px 25px;

    margin:8px 15px;

    border-radius:15px;

    transition:.3s;


}



.sidebar a:hover{


    background:
    rgba(255,255,255,.15);


    transform:translateX(8px);


}





/* FOOTER SIDEBAR */


.sidebar-footer{


    margin:20px;


    background:
    rgba(255,255,255,.15);


    backdrop-filter:blur(10px);


    padding:15px 20px;


    border-radius:20px;


}





/* CONTENT */


.content{


    margin-left:280px;


}





.navbar-custom{


    background:white;

    box-shadow:
    0 3px 10px rgba(0,0,0,.1);


}





footer{


    text-align:center;

    padding:20px;

    color:#666;


}



</style>


</head>




<body>




<!-- SIDEBAR -->


<div class="sidebar">



<div class="sidebar-logo">


<h1>
MERPATI
</h1>


<small>
TVRI NTB
</small>


</div>





<div class="sidebar-menu">



<a href="/admin/dashboard">

<i class="bi bi-grid fs-5"></i>

Dashboard

</a>





<a href="/admin/users">

<i class="bi bi-people fs-5"></i>

Kelola User

</a>





<a href="/admin/template-surat">

<i class="bi bi-file-earmark-text fs-5"></i>

Template Surat

</a>





<a href="/admin/nomor-surat">

<i class="bi bi-hash fs-5"></i>

Nomor Surat

</a>





<a href="/admin/laporan">

<i class="bi bi-file-earmark-bar-graph fs-5"></i>

Laporan

</a>





<a href="/admin/grafik">

<i class="bi bi-bar-chart-line fs-5"></i>

Grafik

</a>





<a href="/admin/arsip">

<i class="bi bi-archive fs-5"></i>

Arsip

</a>





<a href="/admin/monitoring">

<i class="bi bi-activity fs-5"></i>

Monitoring

</a>





<a href="/admin/setting">

<i class="bi bi-gear fs-5"></i>

Setting

</a>



</div>







<div class="sidebar-footer">


<small>

Sistem E-Surat

</small>


<br>


<b>

TVRI NTB

</b>


</div>





</div>







<!-- CONTENT -->


<div class="content">





<nav class="navbar navbar-expand-lg navbar-custom">


<div class="container-fluid">



<span class="navbar-brand fw-bold">

@yield('title')

</span>




<div class="ms-auto d-flex align-items-center">



<button class="btn btn-light me-3">


<i class="bi bi-bell"></i>


</button>





<img

src="https://ui-avatars.com/api/?name=Admin"

width="40"

class="rounded-circle"

/>



</div>



</div>


</nav>







<div class="container-fluid mt-4">


@yield('content')


</div>







<footer>


© {{date('Y')}} MERPATI TVRI NTB


</footer>




</div>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



</body>


</html>