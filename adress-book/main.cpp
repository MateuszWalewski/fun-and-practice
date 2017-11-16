#include <iostream>
#include "Database.h"
#include <stdlib.h>
#include <fstream>
#include <vector>
#include <conio.h>
using namespace std;

void addContact(Database & inDB);
void deleteContact(Database & inDB);
void findContactById(Database & inDB);
void findContactByName(Database & inDB);
void findContactByLastName(Database & inDB);
void cleanScreen();
int displayMenu();

int main()
{
    try
    {
        Database recDB;
        bool done = false;
        while(!done)
        {
            int selection = displayMenu();
            switch(selection)
            {
            case 1:
                addContact(recDB);
                break;
            case 2:
                deleteContact(recDB);
                break;
            case 3:
                recDB.displayAll();
                break;
            case 4:
                findContactById(recDB);
                break;
            case 5:
                findContactByName(recDB);
                break;
            case 6:
                findContactByLastName(recDB);
                break;
            case 0:
                done = true;
                break;
            default:
                cerr << "Unknown command" << endl;
            }
        }
    }
    catch(const exception&)
    {
        cerr<<"Unable to set-up the database" << endl;
    }

    return 0;
}
void addContact(Database & inDB)
{
    string firstName, lastName, phone, adress, email;
    cout << "Type first name:" << endl;
    getline(cin, firstName);
    cout << "Type last name:" << endl;
    getline(cin, lastName);
    cout << "Type phone:" << endl;
    getline(cin, phone);
    cout << "Type adress:" << endl;
    getline(cin, adress);
    cout << "Type email:" << endl;
    getline(cin, email);
    inDB.addRecord(firstName,lastName,phone,adress,email);
    cleanScreen();
}

void deleteContact(Database & inDB)
{
    int recordNumber;
    cout <<"Give the id of the person to be removed" << endl;
    cin >> recordNumber;
    try
    {
        inDB.deleteRecord(recordNumber);
        cleanScreen();
    }
    catch(const exception&)
    {
        cerr<<"There is no record with the given id. Unable to delete contact" << endl;
        cleanScreen();
    }

}
void findContactById(Database & inDB)
{
    int id;
    cout << "Give id of the contact to be find"<<endl;
    cin >> id;
    try
    {
        Record& rec = inDB.getRecordById(id);
        rec.display();
    }
    catch(const exception&)
    {
        cerr<<"There is no contact with the given id" << endl;
        cleanScreen();
    }

}
void findContactByName(Database & inDB)
{
    string name;
    cout << "Give the name of the contact to be find"<<endl;
    cin >> name;
    try
    {
        inDB.findRecordByName(name);
    }
    catch(const exception&)
    {
        cerr<<"There is no contact with the given name" << endl;
        cleanScreen();
    }
}
void findContactByLastName(Database & inDB)
{
    string lastName;
    cout << "Give the last name of the contact to be find"<<endl;
    cin >> lastName;
    try
    {
        inDB.findRecordByLastName(lastName);
    }
    catch(const exception&)
    {
        cerr<<"There is no contact with the given last name" << endl;
        cleanScreen();
    }
}
int displayMenu()
{
    int selection;
    cout << endl;
    cout << "Adress book" << endl;
    cout << "------------" << endl;
    cout << "1) Add new contact" << endl;
    cout << "2) Delete contact" << endl;
    cout << "3) Display all contacts" << endl;
    cout << "4) Find contact by id" << endl;
    cout << "5) Find contact by name" << endl;
    cout << "6) Find contact by last name" << endl;
    cout << "0) Quit" << endl;
    cout << endl;

    while(!(cin >> selection))
    {
        cout <<"Unknown command. Try again..." << endl;
        cin.clear();
        cin.ignore();
    }
    cin.clear();
    cin.ignore();

    return selection;

}
void cleanScreen()
{
   cout <<"Press any key to continue..." << endl;
   getch();
   system("cls");
}
