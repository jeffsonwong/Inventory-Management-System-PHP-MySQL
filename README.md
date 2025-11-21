# Inventory Management System

This project involves the development of a PHP and MySQL-based inventory management website designed for clients to manage various aspects of their business operations, such as customer memberships, item stock, and sales. The website provides a user-friendly interface for managing inventory, processing customer purchases, and generating sales reports.

**Key Features:**

**1. User Authentication:**

- Users can register a new account by providing a username, password, and confirm password.

- After registration, the user is prompted to log in to access the dashboard.

- Authentication ensures that only authorized users can access the system.
  
![login](https://github.com/user-attachments/assets/2eff6877-aef8-48b7-8d0e-d2a5aad50237)
![register](https://github.com/user-attachments/assets/0e6d5ae8-58b4-43cb-a0e2-5599c723aa4f)


**2. Dashboard:**

- The dashboard displays summarized information from the database, with tabs for:

- Customer Memberships: View and manage customer details.

- Items in Stock: View and manage inventory items.

- Customer Purchases: View and manage customer purchase history.

![dashboard](https://github.com/user-attachments/assets/0db88898-234c-449b-9b5a-7c6a41ed686e)


**3. Item Management:**

- Users can add, edit, and delete items in the inventory by entering details such as item name, price, and quantity.

- Once entered, the item information is displayed in a list for easy management.

![item-management](https://github.com/user-attachments/assets/e0680f37-ef2e-41ff-9be0-db46ef74c5e9)


**4. Membership Management:**

- Users can add customers to the membership program by entering customer details like name, phone number, and email.

- The list of customers is displayed for easy reference, and users can also remove customers from the membership list.

![membership-management](https://github.com/user-attachments/assets/4ca32d2c-ca19-4468-8339-43d0bf6778d2)


**5. Purchase Page:**

- Users can choose whether they are making a purchase as a member or a guest.

- The purchase details are recorded, including purchase ID, item information, quantity, unit price, and total price.

![purchase-page](https://github.com/user-attachments/assets/ccf911c3-ed09-4904-a979-42218d66fd96)


**6. Sales Report:**

- A detailed sales report is generated, showing item purchases with relevant information such as purchase ID, member ID, member name, item details, and total price.

- Users can delete records directly from this page.

![sales-report](https://github.com/user-attachments/assets/28342fbd-90a8-4b7c-bc66-cf48bb8c2d38)


**Security Features:**

**1. Password Hashing:**

User passwords are securely hashed using a hashing algorithm before being stored in the database, ensuring that the passwords cannot be accessed by unauthorized individuals.

**2. Input Validation:**

To prevent SQL injection and cross-site scripting (XSS) attacks, all user inputs are validated before being processed. This ensures the integrity and security of the data.

**3. Session Management:**

The system ensures that users cannot access pages unless they are logged in. Secure sessions are used to manage user login states, and users are logged out automatically after a period of inactivity for added security.
