function enableInputs() {
    // Enable name, phone, and gender inputs
    document.getElementById('formHeading').innerText = 'Sử dụng 1 ngày';
    document.getElementById('user_id').setAttribute('readonly', true);
    document.getElementById('myForm').name.removeAttribute('readonly');
    document.getElementById('myForm').phone.removeAttribute('readonly');
    document.getElementById('maleRadio').removeAttribute('disabled');
    document.getElementById('femaleRadio').removeAttribute('disabled');

    document.getElementById('dobInput').style.display = 'block';

    document.getElementById('backButton').style.display = 'inline-block';
}

function goBack() {
    // Reset heading text
    document.getElementById('formHeading').innerText = 'Dành cho hội viên';

    // Reset form state and disable inputs
    document.getElementById('user_id').removeAttribute('readonly');
    document.getElementById('myForm').name.setAttribute('readonly', 'true');
    document.getElementById('myForm').phone.setAttribute('readonly', 'true');
    document.getElementById('maleRadio').setAttribute('disabled', 'true');
    document.getElementById('femaleRadio').setAttribute('disabled', 'true');

    document.getElementById('dobInput').style.display = 'none';

    document.getElementById('backButton').style.display = 'none';
}