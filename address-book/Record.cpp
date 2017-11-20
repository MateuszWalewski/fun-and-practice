#include "Record.h"
#include <iostream>
using namespace std;

Record::Record()
:
    firstName(""),
    lastName(""),
    phone(""),
    adress(""),
    email("")
    {

    }

void Record::setFirstName(string inFirstName)
{
    firstName = inFirstName;
}
string Record::getFirstName() const
{
    return firstName;
}
void Record::setLastName(string inLastName)
{
    lastName = inLastName;
}
string Record::getLastName() const
{
    return lastName;
}
void Record::setPhone(string inPhone)
{
    phone = inPhone;
}
string Record::getPhone() const
{
    return phone;
}
void Record::setAdress(string inAdress)
{
    adress = inAdress;
}
string Record::getAdress() const
{
    return adress;
}
void Record::setEmail(string inEmail)
{
    email = inEmail;
}
string Record::getEmail() const
{
    return email;
}
void Record::setRecordNumber(int inRecNumber)
{
    recordNumber = inRecNumber;
}
int Record::getRecordNumber() const
{
    return recordNumber;
}
void Record::display() const
{
    cout <<"------------------------------------------" << endl;
    cout << " Name and surname: " << getFirstName() <<" "<< getLastName() <<endl;
    cout << " Phone number: " << getPhone() << endl;
    cout << " Adress: " << getAdress() << endl;
    cout << " E-mail: " << getEmail() << endl;
    cout << " Id: " << getRecordNumber() << endl;

}


