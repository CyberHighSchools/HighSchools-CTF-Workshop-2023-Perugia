const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
const appendAlert = (message, type) => {
    const wrapper = document.createElement('div')
    wrapper.innerHTML = [
        `<div class="mt-4 col-md-auto alert alert-${type} alert-dismissible" role="alert">`,
        `${message}`,
        '   <button id="hideButton" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        '</div>'
    ].join('')

    alertPlaceholder.append(wrapper)
}

function playNumber() {
    var hideButton = document.getElementById('hideButton')
    if (hideButton) {
        hideButton.click()
    }
    const number = document.getElementById('lottery-number').value
    const url = `/play/${number}`
    if (number < 1 || number > 25) {
        appendAlert('Inserisci un numero compreso tra 1 e 25', 'danger')
        return
    }
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                appendAlert(data.error, 'danger')
            } else {
                appendAlert(data.message, 'success')
            }
        })
        .catch(error => {
            appendAlert(error, 'danger')
        })
}
