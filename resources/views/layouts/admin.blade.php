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
<script src="https://unpkg.com/lucide@latest"></script>


@vite([
'resources/css/app.css',
'resources/js/app.js'
])



<style>


body{

    background:#f4f6f9;

}





/* =========================
        SIDEBAR
========================= */


.sidebar{


    width:280px;


    height:100vh;


    position:fixed;


    left:0;


    top:0;



    background:
linear-gradient(
    180deg,
    #07163f,
    #123b91,
    #0796e8
);



    color:white;


    overflow-y:auto;


    box-shadow:
    0 0 30px rgba(0,0,0,.35);



    display:flex;


    flex-direction:column;


}



.sidebar::-webkit-scrollbar{

    width:6px;

}



.sidebar::-webkit-scrollbar-thumb{

    background:rgba(96,165,250,.5);

    border-radius:20px;

}





/* =========================
        LOGO
========================= */


.sidebar-logo{

    padding:35px 25px 25px;

    border-bottom:

    1px solid rgba(255,255,255,.15);

}



.brand{

    display:flex;

    align-items:center;

    gap:18px;

}



.brand-icon{

    width:70px;
    height:70px;

    border-radius:18px;

    background:
    linear-gradient(
        135deg,
        #38bdf8,
        #2563eb
    );

    display:flex;
    align-items:center;
    justify-content:center;

    overflow:hidden;

    box-shadow:
    0 10px 25px rgba(37,99,235,.45);

}



.brand-icon i{

    font-size:32px;

    color:white;

}

.brand-bird{

    width:32px;

    height:32px;

    color:white;

}

.brand-text h1{

    font-size:30px;

    font-weight:900;

    letter-spacing:2px;

}



.brand-text p{

    margin-top:5px;

    margin-bottom:0;

    color:#dbeafe;

    font-size:16px;

    font-weight:600;

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


    color:#dbeafe;


    text-decoration:none;


    padding:14px 25px;


    margin:8px 15px;


    border-radius:15px;


    transition:.3s;


}



.sidebar a:hover{


    background:rgba(255,255,255,.1);


    color:white;


    transform:translateX(8px);


}




.menu-title{


    padding:15px 25px 5px;


    color:#bfdbfe;


    font-size:12px;


    font-weight:bold;


    letter-spacing:1px;


}





.sidebar-footer{


    margin:20px;


    background:
    rgba(255,255,255,.1);


    backdrop-filter:blur(10px);


    padding:18px 20px;


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



<div class="brand">



<div class="brand-icon">

    <i 
    data-lucide="bird"
    class="w-8 h-8 text-white">
    </i>

</div>





<div class="brand-text">


<h1>
MERPATI
</h1>


<p>
TVRI NTB
</p>


</div>


</div>



</div>





<div class="sidebar-menu">
    {{-- DASHBOARD --}}

<a href="/admin/dashboard">

<i class="bi bi-grid fs-5"></i>

Dashboard

</a>






{{-- MENU SURAT --}}


<div class="menu-title">

SURAT

</div>





<a href="/inbox">

<i class="bi bi-inbox fs-5"></i>

Kotak Masuk

</a>





<a href="/surat/draft">

<i class="bi bi-file-earmark-text fs-5"></i>

Draft

</a>





<a href="/surat/baru">

<i class="bi bi-file-earmark-plus fs-5"></i>

Surat Baru

</a>





<a href="/surat/approval">

<i class="bi bi-check-circle fs-5"></i>

Approval

</a>





<a href="/surat/disposisi">

<i class="bi bi-send fs-5"></i>

Disposisi

</a>





<a href="/surat/arsip">

<i class="bi bi-archive fs-5"></i>

Arsip

</a>





<a href="/profile">

<i class="bi bi-person fs-5"></i>

Profil

</a>







{{-- ADMINISTRATOR --}}


<div class="menu-title">

ADMINISTRATOR

</div>






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






<a href="/admin/monitoring">

<i class="bi bi-activity fs-5"></i>

Monitoring

</a>






<a href="/admin/setting">

<i class="bi bi-gear fs-5"></i>

Setting

</a>





</div>









{{-- FOOTER SIDEBAR --}}


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



<div class="d-flex align-items-center">



<img 

src="{{ asset('images/tvri-ntb.jpeg') }}"

width="55"

height="55"

class="rounded-circle me-3"

style="object-fit:cover;"

>



<span class="navbar-brand fw-bold">

@yield('title')

</span>



</div>






<div class="ms-auto d-flex align-items-center">



<button class="btn btn-light me-3">


<i class="bi bi-bell"></i>


</button>






<img

src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}"

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



<script>

lucide.createIcons();

</script>



</body>


</html>