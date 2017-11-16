#include<iostream>
#include "Database.h"
#include <stdexcept>
#include <fstream>
#include <vector>
#include <stdlib.h>
#include <algorithm>
#include <sstream>

using namespace std;

Database::Database()
{
    records = loadDataFromFile();
    fstream file;
    file.open("AdressBook.txt",ios::in);
    if (file.fail())
    {
        cerr<<"Problem with the file"<<endl;
        throw exception();
    }
    if(file.peek() == ifstream::traits_type::eof()) //check if the file is empty
        nextRecordNumber = 1;
    else
        nextRecordNumber = getLastRecordNumber()+1;
}

int Database::getLastRecordNumber()
{
    auto lastRecord = records.back();
    return lastRecord.getRecordNumber();
}

vector<Record> Database::loadDataFromFile()
{
    string line;
    vector<Record> dataFromFile;
    Record record;
    fstream file;
    file.open("AdressBook.txt",ios::in);
    if (file.fail())
    {
        cerr<<"Problem with the file"<<endl;
        throw exception();
    }
    while (getline(file,line))
    {
        istringstream ss(line);
        string data;
        getline(ss, data, '|');
        record.setRecordNumber(atoi(data.c_str()));
        getline(ss, data, '|');
        record.setFirstName(data);
        getline(ss, data, '|');
        record.setLastName(data);
        getline(ss, data, '|');
        record.setPhone(data);
        getline(ss, data, '|');
        record.setAdress(data);
        getline(ss, data, '|');
        record.setEmail(data);
        dataFromFile.push_back(record);
    }
    file.close();
    return dataFromFile;

}
void Database::addRecord(string firstName, string lastName, string phone, string adress, string email)
{
    Record record;
    record.setFirstName(firstName);
    record.setLastName(lastName);
    record.setPhone(phone);
    record.setAdress(adress);
    record.setEmail(email);
    record.setRecordNumber(nextRecordNumber++);
    records.push_back(record);

    fstream file;
    file.open("AdressBook.txt",ios::out | ios::app);
    file <<record.getRecordNumber()<<"|"<<record.getFirstName()<<"|"<<record.getLastName()<<"|"<<record.getPhone()<<"|"<<record.getAdress()<<"|"<<record.getEmail()<<"|"<<endl;
    file.close();
    cout << endl << "The record has been added" << endl;
}
Record& Database::getRecordById(int recordNumber)
{
    for(auto iter = records.begin(); iter!=records.end(); ++iter)
    {
        if(iter->getRecordNumber() == recordNumber)
            return *iter;
    }
    throw exception();


}
void Database::findRecordByName(string recordName)
{
    bool isInDatabase = false;
    for(auto iter = records.begin(); iter!=records.end(); ++iter)
    {
        if(iter->getFirstName() == recordName)
        {
            iter->display();
            isInDatabase = true;
        }
    }
    if(!isInDatabase) throw exception();
}
void Database::findRecordByLastName(string recordLastName)
{
    bool isInDatabase = false;
    for(auto iter = records.begin(); iter!=records.end(); ++iter)
    {
        if(iter->getLastName() == recordLastName)
        {
            iter->display();
            isInDatabase = true;
        }
    }
    if(!isInDatabase) throw exception();
}

void Database::deleteRecord(int recordNumber)
{
    getRecordById(recordNumber);
    for(auto iter = records.begin(); iter!=records.end();)
    {
        if(iter->getRecordNumber() == recordNumber)
        {
            records.erase(iter);
            cout <<"The contact successfully removed" << endl;
        }
        else
            ++iter;
    }
    fstream file;
    file.open("AdressBook.txt",ios::out | ios::trunc);
    for(auto iter = records.begin(); iter!=records.end(); ++iter)
    {
        file <<iter->getRecordNumber()<<"|"<<iter->getFirstName()<<"|"<<iter->getLastName()<<"|"<<iter->getPhone()<<"|"<<iter->getAdress()<<"|"<<iter->getEmail()<<"|"<<endl;
    }
    file.close();
}


void Database::displayAll() const
{
    for(auto iter = records.begin(); iter!=records.end(); ++iter)
    {
        iter->display();
    }
}
