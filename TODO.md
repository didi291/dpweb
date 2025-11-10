# TODO: Add Password Field to Client and Supplier Registration and Edit Forms

## Steps to Complete

1. **Add password field to view/new-clients.php**
   - Insert a new input field for password after the existing fields, before the rol select.
   - [x] Completed

2. **Add password field to view/new-proveedor.php**
   - Insert a new input field for password after the existing fields, before the rol select.
   - [x] Completed

3. **Add password field to view/edit-client.php**
   - Insert a new input field for password after the existing fields, before the rol select.
   - [x] Completed

4. **Update validation in view/function/clients.js**
   - Add password to the validation function validar_form_client.
   - Ensure password is checked for emptiness.
   - [x] Completed

5. **Update control/ClientsController.php**
   - In the "registrar" section, change password generation from hashing nro_identidad to hashing the provided password.
   - Add password to the validation check.
   - In the "actualizar" section, add password handling.
   - [x] Completed

6. **Update model/ClientsModel.php**
   - Modify the actualizar method to include password in the UPDATE query.
   - [x] Completed

## Followup Steps
- [] Test registration of new clients and suppliers with password.
- [] Test updating existing clients/suppliers with password changes.
- [] Verify password hashing and storage in database.
