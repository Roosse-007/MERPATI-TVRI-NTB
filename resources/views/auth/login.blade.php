<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
Login - MERPATI TVRI NTB
</title>


@vite([
'resources/css/app.css',
'resources/js/app.js'
])

</head>


<body>


<div class="
min-h-screen
relative
overflow-hidden
flex
items-center
justify-center
bg-gradient-to-br
from-slate-950
via-blue-900
to-cyan-500
">


{{-- BACKGROUND GLOW --}}

<div class="
absolute
w-[500px]
h-[500px]
bg-blue-400/20
rounded-full
blur-3xl
top-0
left-0
">
</div>


<div class="
absolute
w-[500px]
h-[500px]
bg-cyan-300/20
rounded-full
blur-3xl
bottom-0
right-0
">
</div>



{{-- BURUNG MERPATI --}}

<div class="
absolute
top-20
right-32
text-8xl
opacity-80
dove-login
">

🕊️

</div>




{{-- LOGIN CARD --}}

<div class="
relative
w-full
max-w-md
bg-white/90
backdrop-blur-xl
rounded-[40px]
shadow-2xl
p-10
">


{{-- LOGO --}}

<div class="text-center">


<div class="
mx-auto
w-24
h-24
rounded-[32px]
bg-gradient-to-br
from-blue-600
to-cyan-400
flex
items-center
justify-center
text-6xl
shadow-xl
">

🕊️

</div>


<h1 class="
mt-6
text-5xl
font-black
tracking-widest
text-slate-800
">

MERPATI

</h1>


<p class="
text-slate-500
mt-2
">

Sistem E-Surat Digital

</p>


<p class="
text-blue-600
font-bold
">

TVRI NUSA TENGGARA BARAT

</p>


</div>





{{-- ERROR MESSAGE --}}

@if ($errors->any())

<div class="
mt-6
bg-red-100
text-red-600
p-4
rounded-xl
text-sm
">

{{ $errors->first() }}

</div>

@endif





{{-- FORM --}}

<form 
action="{{ route('login.process') }}"
method="POST"
class="
mt-10
space-y-6
">

@csrf



{{-- USERNAME --}}

<div>


<label class="
font-bold
text-slate-700
">

Username

</label>


<div class="relative mt-2">


<span class="
absolute
left-4
top-4
">

👤

</span>



<input

type="text"

name="username"

value="{{ old('username') }}"

placeholder="Masukkan username"

required

class="
w-full
rounded-2xl
bg-slate-100
border-none
pl-12
py-4
outline-none
focus:ring-2
focus:ring-blue-500
transition
"


>


</div>


</div>





{{-- PASSWORD --}}

<div>


<label class="
font-bold
text-slate-700
">

Password

</label>


<div class="relative mt-2">


<span class="
absolute
left-4
top-4
">

🔒

</span>



<input

type="password"

name="password"

placeholder="********"

required

class="
w-full
rounded-2xl
bg-slate-100
border-none
pl-12
py-4
outline-none
focus:ring-2
focus:ring-blue-500
transition
"


>


</div>


</div>






<button

type="submit"

class="
w-full
py-4
rounded-2xl
bg-gradient-to-r
from-blue-600
to-cyan-400
text-white
font-black
text-lg
shadow-xl
hover:scale-105
transition
"

>


Masuk

</button>



</form>







<div class="
mt-8
text-center
text-sm
text-slate-400
">

© {{ date('Y') }} MERPATI TVRI NTB

</div>



</div>



</div>


</body>

</html>