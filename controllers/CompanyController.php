<?php
// Company Controller - Handles company-related requests
require_once 'models/CompanyModel.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

switch($action) {
    case 'list':
        $companies = getAllCompanies();
        require_once 'views/company/list.php';
        break;
        
    case 'view':
        if(isset($_GET['id'])) {
            $company = getCompanyById($_GET['id']);
            require_once 'views/company/view.php';
        } else {
            header('Location: index.php?page=company&action=list');
        }
        break;
        
    case 'create':
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = array(
                'company_name' => $_POST['company_name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'description' => $_POST['description'],
                'website' => $_POST['website']
            );
            
            if(createCompany($data)) {
                $_SESSION['success'] = "Company profile created successfully!";
                header('Location: index.php?page=company&action=list');
                exit();
            } else {
                $_SESSION['error'] = "Failed to create company profile.";
            }
        }
        require_once 'views/company/create.php';
        break;
        
    case 'edit':
        if(isset($_GET['id'])) {
            $company = getCompanyById($_GET['id']);
            
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = array(
                    'company_name' => $_POST['company_name'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'address' => $_POST['address'],
                    'description' => $_POST['description'],
                    'website' => $_POST['website']
                );
                
                if(updateCompany($_GET['id'], $data)) {
                    $_SESSION['success'] = "Company profile updated successfully!";
                    header('Location: index.php?page=company&action=view&id=' . $_GET['id']);
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to update company profile.";
                }
            }
            
            require_once 'views/company/edit.php';
        } else {
            header('Location: index.php?page=company&action=list');
        }
        break;
        
    case 'delete':
        if(isset($_GET['id'])) {
            if(deleteCompany($_GET['id'])) {
                $_SESSION['success'] = "Company deleted successfully!";
            } else {
                $_SESSION['error'] = "Failed to delete company.";
            }
        }
        header('Location: index.php?page=company&action=list');
        break;
        
    default:
        header('Location: index.php?page=company&action=list');
        break;
}
?>
