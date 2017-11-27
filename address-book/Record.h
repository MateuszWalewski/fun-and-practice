#ifndef RECORD_H
#define RECORD_H

#include <string>
using namespace std;


class Record
{

public:
    Record();

    void setFirstName(string );
    string getFirstName() const;
    void setLastName(string);
    string getLastName() const;
    void setPhone(string);
    string getPhone() const;
    void setAdress(string);
    string getAdress()const;
    void setEmail(string);
    string getEmail() const;
    void display() const;
    void setRecordNumber(int);
    int getRecordNumber() const;
    bool operator<(const Record& rec) const;


private:
    string firstName;
    string lastName;
    string phone;
    string adress;
    string email;
    int recordNumber;

};
#endif
