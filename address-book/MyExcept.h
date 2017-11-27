#ifndef MYEXCEPT_H
#define MYEXCEPT_H

#include<iostream>
using namespace std;

class MyExcept
{
public:
    virtual ~MyExcept() = 0;
    virtual string description() = 0;
};
#endif
