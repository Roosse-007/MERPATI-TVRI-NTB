import Chart from 'chart.js/auto';

window.Chart = Chart;

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

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchAktivitas');

    if (searchInput) {

        searchInput.addEventListener('input', function () {

            const keyword = this.value.toLowerCase();

            document.querySelectorAll('.aktivitas-row')
                .forEach(row => {

                    const text = row.innerText.toLowerCase();

                    if (text.includes(keyword)) {

                        row.style.display = '';

                    } else {

                        row.style.display = 'none';

                    }

                });

        });

    }

});