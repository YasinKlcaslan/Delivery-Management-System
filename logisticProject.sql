use logisticproject;
CREATE TABLE IF NOT EXISTS SHIPMENT (
	Cargo_ID INT PRIMARY KEY,
    Cargo_Weight DECIMAL(10, 2) NOT NULL,
    Cargo_Content VARCHAR(255) NOT NULL,
    Cargo_Payment ENUM('Sender Pay', 'Buyer Pay') NOT NULL,
    Cargo_Fee DECIMAL(10, 2) NOT NULL,
    Cargo_Status ENUM('Getting Ready', 'On the Road', 'Delivered') NOT NULL
);

CREATE TABLE IF NOT EXISTS ROUTE (
    Cargo_ID INT PRIMARY KEY,
    Cargo_From_Where ENUM('Istanbul','Ankara','Izmir','Adana','Mersin') NOT NULL,
    Cargo_From_Where_Employee VARCHAR(255) NOT NULL,
    Cargo_From_Where_Customer_Name_and_Surname VARCHAR(255) NOT NULL,
    Cargo_From_Where_Customer_Phone_Number VARCHAR(15) NOT NULL,
    Cargo_From_Where_Transaction_Date_and_Time DATETIME NOT NULL,
    Cargo_To_Where ENUM('Istanbul','Ankara','Izmir','Adana','Mersin') NOT NULL,
    Cargo_To_Where_Employee VARCHAR(255) NOT NULL,
    Cargo_To_Where_Customer_Name_and_Surname VARCHAR(255) NOT NULL,
    Cargo_To_Where_Customer_Phone_Number VARCHAR(15) NOT NULL,
    FOREIGN KEY (Cargo_ID) REFERENCES SHIPMENT(Cargo_ID)
);

CREATE TABLE IF NOT EXISTS USER (
    User_ID INT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
	INDEX admin (Username)
);

CREATE TABLE IF NOT EXISTS COMMENT (
    Comment_ID INT PRIMARY KEY,
    Username VARCHAR(255),
    Comment TEXT,
    FOREIGN KEY (Username) REFERENCES USER (Username)
);