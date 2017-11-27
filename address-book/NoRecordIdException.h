#ifndef NORECORDIDEXCEPTION_H
#define NORECORDIDEXCEPTION_H

#include<exception>

using namespace std;


class NoRecordIdException : public exception
{
virtual const char* what() const throw();

};
#endif
