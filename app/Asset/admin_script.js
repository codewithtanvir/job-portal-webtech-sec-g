function ShowSection(secction){
    document.getElementById("overview").style.display="none";
    document.getElementById("manageUsers").style.display="none";
    document.getElementById("manageJobs").style.display="none";
    document.getElementById("applications").style.display="none";    
    document.getElementById("reports").style.display="none";    
    document.getElementById("notifications").style.display="none";    
    document.getElementById("activityLogs").style.display="none";    
    document.getElementById("dataExport").style.display="none";    

    document.getElementById(secction).style.display="block";
}