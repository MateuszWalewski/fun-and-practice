#ifndef NORECORDNAMEEXCEPTION_H
#define NORECORDNAMEEXCEPTION_H

#include<exception>

using namespace std;


class NoRecordNameException : public exception
{
virtual const char* what() const throw();

};
#endif




