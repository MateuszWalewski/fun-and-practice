#ifndef ARRAYSORTERINSERTION_H
#define ARRAYSORTERINSERTION_H

#include <iostream>
#include "ArraySorter.h"

using namespace std;


class ArraySorterInsertionSort : public ArraySorter
{

public:

    ArraySorterInsertionSort(int, int[]);
    virtual ~ArraySorterInsertionSort();
    virtual void launch();

private:
    int numberOfElements;
    int* tab;


};
#endif
