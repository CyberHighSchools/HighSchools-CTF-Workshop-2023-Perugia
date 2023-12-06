function checkErrors(error) {

    // Check value of g
    if (error.includes('g')) {
        document.getElementById('dh_g').classList.add('is-invalid');
        document.getElementById('g_invalid').innerText = 'g deve essere compreso tra 1 e p-1';
    }
    // Check value of p
    if (error.includes('p')) {
        document.getElementById('dh_p').classList.add('is-invalid');
        document.getElementById('p_invalid').innerText = 'p deve essere maggiore di 2^512 e minore di 2^1024 e primo';
    }
    // Check value of A
    if (error.includes('A')) {
        document.getElementById('dh_A').classList.add('is-invalid');
        document.getElementById('A_invalid').innerText = 'A deve essere compreso tra 1 e p-1';
    }
}

function checkInput() {
    var g = document.getElementById('dh_g').value;
    var p = document.getElementById('dh_p').value;
    var A = document.getElementById('dh_A').value;

    // Check value of g
    if (g < 1 || g > p - 1) {
        // Input is invalid
        document.getElementById('dh_g').classList.add('is-invalid');
        document.getElementById('g_invalid').innerText = 'g deve essere compreso tra 1 e p-1';
        return false;
    } else {
        // Input is valid
        document.getElementById('dh_g').classList.remove('is-invalid');
        document.getElementById('g_invalid').innerText = '';
    }

    // Check value of p
    if (p < 2 ** 512 || p > 2 ** 1024) {
        // Input is invalid
        document.getElementById('dh_p').classList.add('is-invalid');
        document.getElementById('p_invalid').innerText = 'p deve essere maggiore di 2^512 e minore di 2^1024 e primo';
        return false;
    } else {
        // Input is valid
        document.getElementById('dh_p').classList.remove('is-invalid');
        document.getElementById('p_invalid').innerText = '';
    }

    // Check value of A
    if (A < 1 || A > p - 1) {
        // Input is invalid
        document.getElementById('dh_A').classList.add('is-invalid');
        document.getElementById('A_invalid').innerText = 'A deve essere compreso tra 1 e p-1';
        return false;
    } else {
        // Input is valid
        document.getElementById('dh_A').classList.remove('is-invalid');
        document.getElementById('A_invalid').innerText = '';
    }

    return true;
}

function send() {
    var gValue = document.getElementById('dh_g').value;
    var pValue = document.getElementById('dh_p').value;
    var AValue = document.getElementById('dh_A').value;
    if (!checkInput()) {
        return;
    }
    url = `/dh/${gValue}/${pValue}/${AValue}`;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            var error = data['error'];
            if (error) {
                checkErrors(error);
            } else {
                document.getElementById('dh_B').innerText = 'B(hex): ' + data['hexB'];
                document.getElementById('flag').innerText = 'Ecrypted flag(hex): ' + data['hexFlag'];
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}
