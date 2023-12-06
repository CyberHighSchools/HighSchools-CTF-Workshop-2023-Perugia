const alertContainer = document.getElementById('resultContainer')
const appendAlert = (message, type) => {
    alertContainer.innerHTML = [
        '<div class="row justify-content-center">',
        `<div class="mt-4 text-center col-md-2 alert alert-${type} alert-dismissible" role="alert">`,
        `${message}`,
        '   <button id="hideButton" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        '</div>',
        '</div>'
    ].join('')
}

function getQueryParam(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

var result = getQueryParam('result')
if (result) {
    appendAlert(`Risposta ${result}!`, result == 'corretta' ? 'success' : 'danger')
}

function checkAnswer() {
    var hideButton = document.getElementById('hideButton')
    if (hideButton) {
        hideButton.click()
    }
    // Get user's answer from the input field
    var userSolution = document.getElementById('userSolution').value;

    // Send a POST request to the Flask endpoint
    fetch('/solve', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ solution: userSolution }),
    })
        .then(response => response.json())
        .then(data => {
            result = data.correct ? "corretta" : "sbagliata";

            // Redirect to home page after 1 second
            setTimeout(function() {
                window.location.href = "/?result=" + encodeURIComponent(result);
            }, 1000);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function saveSession() {
    var hideButton = document.getElementById('hideButton')
    if (hideButton) {
        hideButton.click()
    }
    // Make an AJAX request to the Flask route
    fetch('/save_session')
        .then(response => response.json())
        .then(data => {
            document.getElementById('tokenDisplay').innerHTML = data.token
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
