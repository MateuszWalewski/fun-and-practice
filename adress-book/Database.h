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
   void displayAll() const;
   Record& getRecordById(int);
   void findRecordByName(string);
   void findRecordByLastName(string);
   void deleteRecord(int);
   vector<Record> loadDataFromFile();
   int getLastRecordNumber();
   bool myfunction (Record i,Record j);


private:
    vector<Record> records;
    int nextRecordNumber;





};

