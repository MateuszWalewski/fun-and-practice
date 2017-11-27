#include <iostream>
#include "Database.h"
#include <stdlib.h>
#include <fstream>
#include <vector>
#include <conio.h>
#include "NoRecordIdException.h"
#include "NoRecordNameException.h"
#include "NoRecordLastNameException.h"
#include "ProblemWithFileMyExcept.h"

using namespace std;


void displayMenu();
int fetchSelection();
void addContact(Database & inDB);
void deleteContact(Database & inDB);
void findContactById(Database & inDB);
void findContactByName(Database & inDB);
void findContactByLastName(Database & inDB);
void cleanScreen();
void clearIOBuffer();



int main()
{

    try
    {
        Database recDB;
        bool done = false;
        while(!done)
        {
            displayMenu();
            int selection = fetchSelection();
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
    catch(MyExcept& e)
    {
        cerr << e.description() << endl;
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
    try
    {
        inDB.addRecord(firstName,lastName,phone,adress,email);
    }
    catch(const exception&)
    {
        cerr<<"Unable to add new record" << endl;
    }


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
    catch(const exception& e)
    {
        cerr << e.what() << endl;
        cerr <<"Unable to delete contact" << endl;
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
    catch(const exception& e)
    {
        cerr << e.what() << endl;
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
    catch(const exception& e)
    {
        cerr << e.what() << endl;
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
    catch(const exception& e)
    {
        cerr << e.what() << endl;
        cleanScreen();
    }
}
void displayMenu()
{
    int selection;
    cout << endl;
    cout << "Adress book" << endl;
    cout << "------------" << endl;
    cout << "1) Add new contact" << endl;
    cout << "2) Delete contact" << endl;
    cout << "3) Display all contacts (sorted by last name)" << endl;
    cout << "4) Find contact by id" << endl;
    cout << "5) Find contact by name" << endl;
    cout << "6) Find contact by last name" << endl;
    cout << "0) Quit" << endl;
    cout << endl;

}
int fetchSelection()
{
    int selection;
    while(!(cin >> selection))
    {
        cout <<"Unknown command. Try again..." << endl;
        clearIOBuffer();
    }
    clearIOBuffer();
    return selection;

}
void cleanScreen()
{
    cout <<"Press any key to continue..." << endl;
    getch();
    system("cls");
    clearIOBuffer();
}
void clearIOBuffer()
{
    cin.clear();
    cin.ignore();
}
