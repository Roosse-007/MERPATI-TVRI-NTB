@extends('layouts.app')

@section('title','Edit Profil')

@section('content')


<div class="max-w-5xl mx-auto py-6">


<div class="
relative
overflow-hidden
rounded-[40px]
bg-white
shadow-2xl
border
border-slate-100
">



{{-- TOP BANNER --}}

<div class="
relative
h-48
bg-gradient-to-br
from-[#0f3fa8]
via-[#2563eb]
to-[#22d3ee]
">


<div class="
absolute
w-96
h-96
bg-white/10
rounded-full
-top-40
-right-20
blur-2xl
">
</div>


<div class="
absolute
bottom-0
left-0
w-full
h-20
bg-gradient-to-t
from-black/10
to-transparent
">
</div>




<div class="
absolute
bottom-[-50px]
left-10
">


<div class="
w-36
h-36
rounded-full
bg-white
shadow-xl
flex
items-center
justify-center
border-8
border-white/50
">


<div class="
w-28
h-28
rounded-full
bg-gradient-to-br
from-blue-600
to-cyan-400
flex
items-center
justify-center
text-white
">


<i data-lucide="user-round"
class="w-14 h-14">
</i>


</div>


</div>


</div>





<div class="
absolute
bottom-8
left-56
text-white
">


<h1 class="
text-4xl
font-black
">
Edit Profil
</h1>


<p class="
text-blue-100
mt-1
">
Kelola informasi akun dan keamanan pengguna
</p>


</div>



</div>







<div class="pt-20 px-10 pb-10">





@if(session('success'))

<div class="
bg-green-100
text-green-700
rounded-2xl
p-4
mb-6
font-semibold
">

{{session('success')}}

</div>

@endif





@if($errors->any())

<div class="
bg-red-100
text-red-700
rounded-2xl
p-4
mb-6
">


<ul class="list-disc pl-5">

@foreach($errors->all() as $error)

<li>
{{$error}}
</li>

@endforeach

</ul>


</div>

@endif







<form
method="POST"
action="{{route('profile.update')}}">


@csrf
@method('PUT')








{{-- DATA PROFIL --}}


<div class="
grid
lg:grid-cols-2
gap-8
mb-10
">





<div class="
rounded-3xl
bg-gradient-to-br
from-cyan-50
to-blue-50
p-7
border
border-blue-100
shadow-lg
">



<div class="
flex
items-center
gap-3
mb-6
">


<div class="
p-3
rounded-2xl
bg-blue-100
text-blue-600
">

<i data-lucide="id-card"
class="w-6 h-6">
</i>


</div>


<div>

<h2 class="
font-bold
text-xl
">

Informasi Profil

</h2>


<p class="
text-sm
text-slate-400
">

Data pengguna

</p>


</div>



</div>





<div class="space-y-5">



<div>


<label class="
font-semibold
text-slate-700
block
mb-2
">

Nama

</label>


<input

type="text"

name="name"

value="{{old('name',$user->name)}}"

class="
w-full
rounded-2xl
border-none
bg-white
px-5
py-4
shadow-sm
focus:ring-2
focus:ring-blue-500
outline-none
">


</div>






<div>


<label class="
font-semibold
text-slate-700
block
mb-2
">

Email

</label>


<input

type="email"

name="email"

value="{{old('email',$user->email)}}"

class="
w-full
rounded-2xl
border-none
bg-white
px-5
py-4
shadow-sm
focus:ring-2
focus:ring-blue-500
outline-none
">


</div>


</div>


</div>









{{-- SECURITY CARD --}}



<div class="
rounded-3xl
bg-gradient-to-br
from-blue-50
to-cyan-50
p-7
border
border-blue-100
">


<div class="
flex
items-center
gap-3
mb-6
">


<div class="
p-3
rounded-2xl
bg-blue-600
text-white
">


<i data-lucide="shield-check"
class="w-6 h-6">
</i>


</div>


<div>


<h2 class="
font-bold
text-xl
">

Keamanan

</h2>


<p class="
text-sm
text-slate-500
">

Verifikasi password akun

</p>


</div>


</div>





@foreach([
[
'id'=>'current_password',
'name'=>'current_password',
'label'=>'Password Lama'
],

[
'id'=>'password',
'name'=>'password',
'label'=>'Password Baru'
],

[
'id'=>'password_confirmation',
'name'=>'password_confirmation',
'label'=>'Konfirmasi Password'
]

] as $field)



<div class="mb-5">


<label class="
block
font-semibold
mb-2
text-slate-700
">

{{$field['label']}}

</label>




<div class="relative">


<input

id="{{$field['id']}}"

type="password"

name="{{$field['name']}}"

class="
w-full
rounded-2xl
bg-white
border-none
px-5
py-4
pr-14
shadow-sm
focus:ring-2
focus:ring-blue-500
outline-none
"

placeholder="{{$field['label']}}">


<button
type="button"
data-target="{{ $field['id'] }}"
data-icon="icon-{{ $field['id'] }}"
onclick="togglePassword(this.dataset.target,this.dataset.icon)"
class="
absolute
right-5
top-1/2
-translate-y-1/2
text-slate-400
hover:text-blue-600
">

<i
id="icon-{{ $field['id'] }}"
data-lucide="eye"
class="w-5 h-5">
</i>

</button>


</div>



</div>


@endforeach





</div>





</div>







<div class="
flex
justify-end
gap-4
">


<a

href="{{route('profile')}}"

class="
px-8
py-4
rounded-2xl
bg-slate-200
font-bold
hover:bg-slate-300
transition
">

Batal

</a>





<button

class="
px-8
py-4
rounded-2xl
bg-gradient-to-r
from-blue-600
to-cyan-400
text-white
font-bold
shadow-xl
hover:scale-105
transition
">

Simpan Perubahan

</button>



</div>




</form>



</div>


</div>


</div>







<script>

function togglePassword(inputId,iconId)
{

let input=document.getElementById(inputId);

let icon=document.getElementById(iconId);



if(input.type==="password")
{

input.type="text";

icon.setAttribute(
"data-lucide",
"eye-off"
);


}

else
{

input.type="password";


icon.setAttribute(
"data-lucide",
"eye"
);


}


lucide.createIcons();


}

</script>


@endsection