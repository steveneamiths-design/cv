document.getElementById('cvForm').addEventListener('submit', function(e) {
    e.preventDefault();

    document.getElementById('out-name').innerText = document.getElementById('in-name').value;
    document.getElementById('out-profession').innerText = document.getElementById('in-profession').value;
    document.getElementById('out-email').innerText = document.getElementById('in-email').value;
    document.getElementById('out-phone').innerText = document.getElementById('in-phone').value;
    document.getElementById('out-address').innerText = document.getElementById('in-address').value;
    document.getElementById('out-summary').innerText = `"${document.getElementById('in-summary').value}"`;
    
    document.getElementById('out-job-title').innerText = document.getElementById('in-job-title').value;
    document.getElementById('out-company').innerText = document.getElementById('in-company').value;
    document.getElementById('out-job-duration').innerText = document.getElementById('in-job-duration').value;
    document.getElementById('out-job-desc').innerText = document.getElementById('in-job-desc').value;
    
    document.getElementById('out-degree').innerText = document.getElementById('in-degree').value;
    document.getElementById('out-school').innerText = document.getElementById('in-school').value;
    document.getElementById('out-grad-year').innerText = document.getElementById('in-grad-year').value;

    const skillsString = document.getElementById('in-skills').value;
    const skillsArray = skillsString.split(',');
    const skillsList = document.getElementById('out-skills');
    skillsList.innerHTML = '';
    
    skillsArray.forEach(skill => {
        if(skill.trim() !== '') {
            const li = document.createElement('li');
            li.innerText = skill.trim();
            skillsList.appendChild(li);
        }
    });

    const imageInput = document.getElementById('in-pic');
    if (imageInput.files && imageInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('out-pic').src = event.target.result;
            
            document.getElementById('form-section').style.display = 'none';
            document.getElementById('cv-section').style.display = 'flex';
        }
        reader.readAsDataURL(imageInput.files[0]);
    }
});

document.getElementById('resetBtn').addEventListener('click', function() {
    document.getElementById('cv-section').style.display = 'none';
    document.getElementById('form-section').style.display = 'block';
});
