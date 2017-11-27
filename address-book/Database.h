#ifndef DATABASE_H
#define DATABASE_H

#include <iostream>
#include <vector>
#include <string>
#include "Record.h"


using namespace std;

class Database
{

public:
   Database();

   void addRecord(string, string, string, string, string);
   void displayAll();
   Record& getRecordById(int);
   void findRecordByName(string);
   void findRecordByLastName(string);
   void deleteRecord(int);

private:
    vector<Record> records;
    int nextRecordNumber;
    string fileName;

    void saveInDatabase(Record& record);
    vector<Record> loadDataFromFile();
    void updateFile();
    int getLastRecordNumber();
    void sortContactsByLastName();

};
#endif
