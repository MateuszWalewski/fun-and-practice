#ifndef PROBLEMWITHFILEMYEXCEPT_H
#define PROBLEMWITHFILEMYEXCEPT_H


#include "MyExcept.h"
#include <exception>

class ProblemWithFileMyExcept : public MyExcept
{
public:
    ProblemWithFileMyExcept();
    ProblemWithFileMyExcept(const string &);
    virtual ~ProblemWithFileMyExcept();
    virtual string description();
private:
    string fileName;

};
#endif
