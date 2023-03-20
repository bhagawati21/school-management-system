function show(){
    var photo = document.forms['myForm']['photo'];
    if(photo.value !== "")
    {
        var image = document.getElementById('image');
        if(photo.files[0].size > 5000000)
        {
            warningNotification("File size must be 5 Mb or less");
            photo.value = "";
            image.src = "img/default-user.jpg";
        }
        else if(photo.files[0].name.split('.').pop() == "png" || photo.files[0].name.split('.').pop() == "jpg" || 
                photo.files[0].name.split('.').pop() == "jpeg")
        {
            image.src = window.URL.createObjectURL(photo.files[0]);
        }
        else
        {
            warningNotification("Only jpg, jpeg and png files allowed");
            photo.value = "";
            image.src = "img/default-user.jpg";
        }
    }
}
function clearPhoto()
{
    var image = document.getElementById('image');
    image.src = "img/default-user.jpg";
}

function getFees(classid)
{
    var params = "cid="+classid.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get-fees.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        if(this.status == 200)
        {
            sno = 1;
            total = 0;
            var fees = JSON.parse(this.responseText);
            var output = '';
            if(jQuery.isEmptyObject(fees))
            {
                output = '<tr><td colspan=3 class="text-center font-weight-bold text-danger">No Data</td></tr>';
                output += `<tr><th class='ml-4' colspan=2>Total</th><th><i class="far fa-rupee-sign"></i> <span id='total'>${total}</span></th></tr>`;
            }    
            else
            {
                $.each(fees, function(key, value) {
                    output += `<tr><td>${sno}</td><td>${key}</td><td><i class="far fa-rupee-sign"></i> ${value}</td></tr>`;
                    total += value;
                    sno++;
                });
                output += `<tr><th class='ml-4' colspan=2>Total</th><th><i class="far fa-rupee-sign"></i> <span id='total'>${total}</span></th></tr>`;
            }
            document.getElementById('feesDiv').innerHTML = output;
        }           
    }
    xhr.send(params);
}
function getBalance(studentid)
{
    var params = "sid="+studentid.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get-balance.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    const total = document.getElementById('total').innerHTML;
    xhr.onload = function(){
        if(this.status == 200)
        {
            var balance = JSON.parse(this.responseText);
            var output = '';
            if(balance === "No Data")
            {
                output += `<label>Outstanding Balance</label>
                <input type="hidden" id="outstandingduplicate" value="${total}">
                <input type="number" id="outstanding" name="outstanding" class="form-control" value="${total}" readonly>`;
            }
            else
            {
                output += `<label>Outstanding Balance</label>
                           <input type="hidden" id="outstandingduplicate" value="${balance.Outstanding}">
                           <input type="number" id="outstanding" class="form-control" name="outstanding" value="${balance.Outstanding}" readonly>`;
            }
            document.getElementById('balance').innerHTML = output;
        }           
    }
    xhr.send(params);
}

function getStudents(classid)
{
    var params = "cid="+classid.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get-students.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        if(this.status == 200)
        {
            var students = JSON.parse(this.responseText);
            var output = '';

            if(students == "No students")
                output = '<option value="">No students</option>';
            else
            {
                output = '<option value="">Select student</option>';
                for(var i in students)
                {
                    output += '<option value="'+students[i].id+'">'+students[i].Name+'</option>';
                }         
            }
            document.getElementById('sname').innerHTML = output;
        }           
    }
    xhr.send(params);
}


function getSubjects(classid)
{
    var params = "cid="+classid.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get-subjects.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        if(this.status == 200)
        {
            var subjects = JSON.parse(this.responseText);
            var output = '';

            if(subjects == "No subjects")
                output = '<div class="h3 text-center text-danger">No subject for this class is added yet</div>';
            else
            {
                output = '<div class="col-md-6 text-center my-3 py-2 bg-primary rounded-left border-right"><span class="font-weight-bold">Half Yearly exam marks MM (100)</span></div><div class="col-md-6 text-center my-3 py-2 bg-primary rounded-right border-left"><span class="font-weight-bold">Yearly exam marks  MM (100)</span></div>';
                
                for(var i in subjects)
                {
                    var j = parseInt(i)+1;
                    
                    output += '<div class="col-md-6 mb-3"><label>'+subjects[i].SubjectName+' ( '+ subjects[i].SubjectCode +')</label><input type="Number" min=0 max=100 class="form-control" name="'+ subjects[i].id +'_HYE" placeholder="Half Yearly Marks" required></div><div class="col-md-6 mb-3"><label>'+subjects[i].SubjectName+' ( '+ subjects[i].SubjectCode +')</label><input type="Number" min=0 max=100 class="form-control" name="'+ subjects[i].id +'_YE" placeholder="Yearly Marks" required><input type="hidden" value="'+ subjects[i].id +'" name="sub'+ j +'"/></div>';
                }
            }
            document.getElementById('subjects').innerHTML = output;
        }           
    }
    xhr.send(params);
}

function attendanceGetStudents(classid)
{
    var params = "cid="+classid.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get-students.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        if(this.status == 200)
        {
            var students = JSON.parse(this.responseText);
            var output = '<tr><th>Attendance</th><th>Roll Number</th><th>Student Name</th></tr>';

            if(students == "No students")
                output += '<tr><td colspan="3"><strong class="text-danger">No students</strong></td></tr>';
            else
                for(var i in students)
                {
                    //For check box input
                    // output += '<tr><td><input type="checkbox" name="present[]" value="' + students[i].id + '" class="form-check-input" checked></td><td>' + students[i].RollNumber + '</td><td>' + students[i].Name + '</td></tr>';

                    output += '<tr><td><div class="form-check form-check-inline"><input type="radio" name="attendance[' + students[i].id + ']" value="0" class="form-check-input"><label class="text-danger mr-2 form-check-label">Absent</label><input type="radio" name="attendance[' + students[i].id + ']" value="1" class="form-check-input" checked><label class="form-check-label text-success">Present</label></div></td><td>' + students[i].RollNumber + '</td><td>' + students[i].Name + '</td></tr>';
                }         
            document.getElementById('table').innerHTML = output;
        }           
    }
    xhr.send(params);
}


function attendanceGetSubjects(classid)
{
    var params = "cid="+classid.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get-subjects.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        if(this.status == 200)
        {
            var subjects = JSON.parse(this.responseText);
            var output = '';

            if(subjects == "No subjects")
                output = '<option value="">No Subjects</option>';
            else
                for(var i in subjects)
                {
                    output += '<option value="' + subjects[i].id + '">' + subjects[i].SubjectName + '(' + subjects[i].SubjectCode + ')' + '</option>';
                }
            document.getElementById('subjects').innerHTML = output;
        }           
    }
    xhr.send(params);
}

function getEmail(studentid)
{
    var params = "sid="+studentid.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get-email.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        if(this.status == 200)
        {
            var data = JSON.parse(this.responseText);
            if(data == "No Data")
            {
                document.getElementById('email').value = "No Data";
                document.getElementById('mnumber').value = "No Data";
            }
            else
            {
                document.getElementById('email').value = data[0].ParentEmail;
                document.getElementById('mnumber').value = data[0].ParentPhoneNumber;
            }
        }           
    }
    xhr.send(params);
}

function errorNotification(msg="Some error occurred while processing.", title = "ERROR") {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "6000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "show",
        "hideMethod": "hide"
    }
    toastr.error(msg, title);
}

function successNotification(msg="Successful.", title = "SUCCESS") {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "6000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "show",
        "hideMethod": "hide"
    }
    toastr.success(msg, title);
}

function infoNotification(msg="Some Information", title = "INFORMATION") {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "6000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "show",
        "hideMethod": "hide"
    }
    toastr.info(msg, title);
}

function warningNotification(msg="Some Warning", title = "WARNING") {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "6000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "show",
        "hideMethod": "hide"
    }
    toastr.warning(msg, title);
}
