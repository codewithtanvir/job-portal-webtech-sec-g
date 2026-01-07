<?php
// Company Model - Handles all database operations for companies

function createCompany($data) {
    $conn = getDBConnection();
    
    $company_name = mysqli_real_escape_string($conn, $data['company_name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $phone = mysqli_real_escape_string($conn, $data['phone']);
    $address = mysqli_real_escape_string($conn, $data['address']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    $website = mysqli_real_escape_string($conn, $data['website']);
    $logo = isset($data['logo']) ? mysqli_real_escape_string($conn, $data['logo']) : '';
    
    $sql = "INSERT INTO companies (company_name, email, phone, address, description, website, logo) 
            VALUES ('$company_name', '$email', '$phone', '$address', '$description', '$website', '$logo')";
    
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    
    return $result;
}

function getCompanyById($id) {
    $conn = getDBConnection();
    
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM companies WHERE id = '$id'";
    
    $result = mysqli_query($conn, $sql);
    $company = mysqli_fetch_assoc($result);
    
    mysqli_close($conn);
    
    return $company;
}

function getAllCompanies() {
    $conn = getDBConnection();
    
    $sql = "SELECT * FROM companies ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    
    $companies = array();
    while($row = mysqli_fetch_assoc($result)) {
        $companies[] = $row;
    }
    
    mysqli_close($conn);
    
    return $companies;
}

function updateCompany($id, $data) {
    $conn = getDBConnection();
    
    $id = mysqli_real_escape_string($conn, $id);
    $company_name = mysqli_real_escape_string($conn, $data['company_name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $phone = mysqli_real_escape_string($conn, $data['phone']);
    $address = mysqli_real_escape_string($conn, $data['address']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    $website = mysqli_real_escape_string($conn, $data['website']);
    
    $sql = "UPDATE companies SET 
            company_name = '$company_name',
            email = '$email',
            phone = '$phone',
            address = '$address',
            description = '$description',
            website = '$website'
            WHERE id = '$id'";
    
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    
    return $result;
}

function deleteCompany($id) {
    $conn = getDBConnection();
    
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "DELETE FROM companies WHERE id = '$id'";
    
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    
    return $result;
}
?>
