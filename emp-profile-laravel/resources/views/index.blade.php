<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .nav-tabs {
            display: flex;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .tab-button {
            flex: 1;
            padding: 20px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            color: #64748b;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }

        .tab-button.active {
            color: #4f46e5;
            background: white;
            border-bottom-color: #4f46e5;
        }

        .tab-button:hover {
            background: #f1f5f9;
            color: #4f46e5;
        }

        .tab-content {
            display: none;
            padding: 40px;
        }

        .tab-content.active {
            display: block;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4f46e5;
            background: white;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #22c55e;
            display: none;
        }

        .submit-btn {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 300px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .employee-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .employee-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .employee-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-color: #4f46e5;
        }

        .employee-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .employee-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            margin-right: 15px;
        }

        .employee-info h3 {
            color: #1f2937;
            font-size: 1.25rem;
            margin-bottom: 5px;
        }

        .employee-info p {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .employee-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-item label {
            font-size: 0.8rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .detail-item span {
            color: #1f2937;
            font-weight: 500;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }

        .no-employees {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .no-employees h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .employee-grid {
                grid-template-columns: 1fr;
            }
            
            .nav-tabs {
                flex-direction: column;
            }
            
            .header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Employee Management System</h1>
            <p>Manage your workforce efficiently and professionally</p>
        </div>

        <div class="nav-tabs">
            <button class="tab-button active" onclick="switchTab('add-employee')">Add Employee</button>
            <button class="tab-button" onclick="switchTab('view-employees')">View Employees</button>
        </div>

        <!-- Add Employee Tab -->
        <div id="add-employee" class="tab-content active">
            <div class="success-message" id="success-message">
                Employee added successfully!
            </div>

            <form id="employee-form">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="employee_name">Employee Name *</label>
                        <input type="text" id="employee_name" name="employee_name" required>
                        <div class="error-message" id="employee_name_error"></div>
                    </div>

                    <div class="form-group">
                        <label for="employee_id">Employee ID *</label>
                        <input type="text" id="employee_id" name="employee_id" required>
                        <div class="error-message" id="employee_id_error"></div>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender *</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                            <option value="Prefer not to say">Prefer not to say</option>
                        </select>
                        <div class="error-message" id="gender_error"></div>
                    </div>

                    <div class="form-group">
                        <label for="marital_status">Marital Status *</label>
                        <select id="marital_status" name="marital_status" required>
                            <option value="">Select Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                        <div class="error-message" id="marital_status_error"></div>
                    </div>

                    <div class="form-group">
                        <label for="phone_no">Phone Number *</label>
                        <input type="tel" id="phone_no" name="phone_no" required>
                        <div class="error-message" id="phone_no_error"></div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                        <div class="error-message" id="email_error"></div>
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth *</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" required>
                        <div class="error-message" id="date_of_birth_error"></div>
                    </div>

                    <div class="form-group">
                        <label for="nationality">Nationality *</label>
                        <input type="text" id="nationality" name="nationality" required>
                        <div class="error-message" id="nationality_error"></div>
                    </div>

                    <div class="form-group">
                        <label for="hire_date">Hire Date *</label>
                        <input type="date" id="hire_date" name="hire_date" required>
                        <div class="error-message" id="hire_date_error"></div>
                    </div>

                    <div class="form-group">
                        <label for="department">Department *</label>
                        <select id="department" name="department" required>
                            <option value="">Select Department</option>
                            <option value="Human Resources">Human Resources</option>
                            <option value="Information Technology">Information Technology</option>
                            <option value="Finance">Finance</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Sales">Sales</option>
                            <option value="Operations">Operations</option>
                            <option value="Customer Service">Customer Service</option>
                            <option value="Research & Development">Research & Development</option>
                        </select>
                        <div class="error-message" id="department_error"></div>
                    </div>

                    <div class="form-group">
                        <label for="position">Position *</label>
                        <input type="text" id="position" name="position" required>
                        <div class="error-message" id="position_error"></div>
                    </div>

                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="number" id="salary" name="salary" min="0" step="0.01">
                        <div class="error-message" id="salary_error"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address *</label>
                    <textarea id="address" name="address" required placeholder="Enter full address"></textarea>
                    <div class="error-message" id="address_error"></div>
                </div>

                <button type="submit" class="submit-btn" id="submit-btn">Add Employee</button>
            </form>
        </div>

        <!-- View Employees Tab -->
        <div id="view-employees" class="tab-content">
            <div class="loading" id="loading">Loading employees...</div>
            <div class="employee-grid" id="employee-grid"></div>
            <div class="no-employees" id="no-employees" style="display: none;">
                <h3>No Employees Found</h3>
                <p>Start by adding your first employee using the "Add Employee" tab.</p>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let employees = [];
        const API_BASE_URL = 'http://localhost:8000/api'; // Laravel backend URL

        // Tab switching functionality
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
            
            // Load employees when switching to view tab
            if (tabName === 'view-employees') {
                loadEmployees();
            }
        }

        // Form validation
        function validateForm() {
            let isValid = true;
            const form = document.getElementById('employee-form');
            const formData = new FormData(form);
            
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(error => {
                error.style.display = 'none';
            });

            // Required field validation
            const requiredFields = ['employee_name', 'employee_id', 'gender', 'marital_status', 'phone_no', 'email', 'date_of_birth', 'nationality', 'hire_date', 'department', 'position', 'address'];
            
            requiredFields.forEach(field => {
                const value = formData.get(field);
                if (!value || value.trim() === '') {
                    showError(field, 'This field is required');
                    isValid = false;
                }
            });

            // Email validation
            const email = formData.get('email');
            if (email && !isValidEmail(email)) {
                showError('email', 'Please enter a valid email address');
                isValid = false;
            }

            // Phone validation
            const phone = formData.get('phone_no');
            if (phone && !isValidPhone(phone)) {
                showError('phone_no', 'Please enter a valid phone number');
                isValid = false;
            }

            // Date validation
            const dob = new Date(formData.get('date_of_birth'));
            const hireDate = new Date(formData.get('hire_date'));
            const today = new Date();

            if (dob >= today) {
                showError('date_of_birth', 'Date of birth must be in the past');
                isValid = false;
            }

            if (hireDate > today) {
                showError('hire_date', 'Hire date cannot be in the future');
                isValid = false;
            }

            // Age validation (minimum 16 years old)
            const age = today.getFullYear() - dob.getFullYear();
            if (age < 16) {
                showError('date_of_birth', 'Employee must be at least 16 years old');
                isValid = false;
            }

            return isValid;
        }

        function showError(fieldName, message) {
            const errorElement = document.getElementById(fieldName + '_error');
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function isValidPhone(phone) {
            const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
            return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
        }

        // Form submission
        document.getElementById('employee-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!validateForm()) {
                return;
            }

            const submitBtn = document.getElementById('submit-btn');
            const originalText = submitBtn.textContent;
            
            try {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Adding Employee...';
                
                const formData = new FormData(this);
                const employeeData = Object.fromEntries(formData.entries());
                
                // Add timestamp
                employeeData.created_at = new Date().toISOString();
                
                // Since we're using a static frontend, we'll use localStorage for demo
                // In a real application, this would be sent to the Laravel backend
                const success = await saveEmployee(employeeData);
                
                if (success) {
                    // Show success message
                    document.getElementById('success-message').style.display = 'block';
                    
                    // Reset form
                    this.reset();
                    
                    // Hide success message after 3 seconds
                    setTimeout(() => {
                        document.getElementById('success-message').style.display = 'none';
                    }, 3000);
                }
                
            } catch (error) {
                alert('Error adding employee: ' + error.message);
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });

        // Save employee (demo version using localStorage)
        async function saveEmployee(employeeData) {
            try {
                // Get existing employees
                const existingEmployees = JSON.parse(localStorage.getItem('employees') || '[]');
                
                // Check for duplicate employee ID
                if (existingEmployees.some(emp => emp.employee_id === employeeData.employee_id)) {
                    throw new Error('Employee ID already exists');
                }
                
                // Add new employee
                existingEmployees.push(employeeData);
                
                // Save to localStorage
                localStorage.setItem('employees', JSON.stringify(existingEmployees));
                
                return true;
            } catch (error) {
                throw error;
            }
        }

        // Load employees
        async function loadEmployees() {
            const loadingElement = document.getElementById('loading');
            const gridElement = document.getElementById('employee-grid');
            const noEmployeesElement = document.getElementById('no-employees');
            
            try {
                loadingElement.style.display = 'block';
                gridElement.innerHTML = '';
                noEmployeesElement.style.display = 'none';
                
                // Get employees from localStorage (demo version)
                const employees = JSON.parse(localStorage.getItem('employees') || '[]');
                
                setTimeout(() => {
                    loadingElement.style.display = 'none';
                    
                    if (employees.length === 0) {
                        noEmployeesElement.style.display = 'block';
                    } else {
                        displayEmployees(employees);
                    }
                }, 500);
                
            } catch (error) {
                loadingElement.style.display = 'none';
                alert('Error loading employees: ' + error.message);
            }
        }

        // Display employees
        function displayEmployees(employees) {
            const gridElement = document.getElementById('employee-grid');
            gridElement.innerHTML = '';
            
            employees.forEach(employee => {
                const employeeCard = createEmployeeCard(employee);
                gridElement.appendChild(employeeCard);
            });
        }

        // Create employee card
        function createEmployeeCard(employee) {
            const card = document.createElement('div');
            card.className = 'employee-card';
            
            const initials = employee.employee_name.split(' ').map(name => name[0]).join('').toUpperCase();
            
            const formatDate = (dateString) => {
                return new Date(dateString).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            };
            
            card.innerHTML = `
                <div class="employee-header">
                    <div class="employee-avatar">${initials}</div>
                    <div class="employee-info">
                        <h3>${employee.employee_name}</h3>
                        <p>${employee.position} • ${employee.department}</p>
                    </div>
                </div>
                <div class="employee-details">
                    <div class="detail-item">
                        <label>Employee ID</label>
                        <span>${employee.employee_id}</span>
                    </div>
                    <div class="detail-item">
                        <label>Email</label>
                        <span>${employee.email}</span>
                    </div>
                    <div class="detail-item">
                        <label>Phone</label>
                        <span>${employee.phone_no}</span>
                    </div>
                    <div class="detail-item">
                        <label>Gender</label>
                        <span>${employee.gender}</span>
                    </div>
                    <div class="detail-item">
                        <label>Marital Status</label>
                        <span>${employee.marital_status}</span>
                    </div>
                    <div class="detail-item">
                        <label>Nationality</label>
                        <span>${employee.nationality}</span>
                    </div>
                    <div class="detail-item">
                        <label>Date of Birth</label>
                        <span>${formatDate(employee.date_of_birth)}</span>
                    </div>
                    <div class="detail-item">
                        <label>Hire Date</label>
                        <span>${formatDate(employee.hire_date)}</span>
                    </div>
                    ${employee.salary ? `
                    <div class="detail-item">
                        <label>Salary</label>
                        <span>$${parseFloat(employee.salary).toLocaleString()}</span>
                    </div>
                    ` : ''}
                    <div class="detail-item" style="grid-column: 1 / -1;">
                        <label>Address</label>
                        <span>${employee.address}</span>
                    </div>
                </div>
            `;
            
            return card;
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Set default dates
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('hire_date').value = today;
            
            // Generate employee ID
            const empId = 'EMP' + Date.now().toString().slice(-6);
            document.getElementById('employee_id').value = empId;
        });
    </script>
</body>
</html>