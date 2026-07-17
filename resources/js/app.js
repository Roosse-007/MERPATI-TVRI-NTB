console.log("MERPATI JS AKTIF");


window.openUserModal = function(){

    let modal = document.getElementById('userModal');

    if(modal){

        modal.classList.remove('hidden');
        modal.classList.add('flex');

    }

};



window.closeUserModal = function(){

    let modal = document.getElementById('userModal');

    if(modal){

        modal.classList.add('hidden');
        modal.classList.remove('flex');

    }

};