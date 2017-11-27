#ifndef NORECORDLASTNAMEEXCEPTION_H
#define NORECORDLASTNAMEEXCEPTION_H

#include<exception>

using namespace std;


class NoRecordLastNameException : public exception
{
virtual const char* what() const throw();

};

#endif
