function validateForm() {
    let isValid = true;

    // Clear previous errors
    document.querySelectorAll('.error').forEach(error => error.style.display = 'none');

    // Validate Job Title
    const jobTitle = document.getElementById('jobTitle').value.trim();
    if (jobTitle === '') {
        document.getElementById('jobTitleError').textContent = 'Job Title is required';
        document.getElementById('jobTitleError').style.display = 'block';
        isValid = false;
    }

    // Validate Job Description
    const jobDescription = document.getElementById('jobDescription').value.trim();
    if (jobDescription === '') {
        document.getElementById('jobDescriptionError').textContent = 'Job Description is required';
        document.getElementById('jobDescriptionError').style.display = 'block';
        isValid = false;
    }

    // Validate Location
    const location = document.getElementById('location').value.trim();
    if (location === '') {
        document.getElementById('locationError').textContent = 'Location is required';
        document.getElementById('locationError').style.display = 'block';
        isValid = false;
    }

    // Validate Salary
    const salary = document.getElementById('salary').value.trim();
    if (salary === '') {
        document.getElementById('salaryError').textContent = 'Salary is required';
        document.getElementById('salaryError').style.display = 'block';
        isValid = false;
    }
      // Validate Job Category
      const jobCategory = document.getElementById('jobCategory').value;
      if (jobCategory === '') {
          document.getElementById('jobCategoryError').textContent = 'Job Category is required';
          document.getElementById('jobCategoryError').style.display = 'block';
          isValid = false;
      }

    // Validate Company Name
    const companyName = document.getElementById('companyName').value.trim();
    if (companyName === '') {
        document.getElementById('companyNameError').textContent = 'Company Name is required';
        document.getElementById('companyNameError').style.display = 'block';
        isValid = false;
    }

    return isValid;
  
}