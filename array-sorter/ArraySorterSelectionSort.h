#ifndef ARRAYSORTERSELECTION_H
#define ARRAYSORTERSELECTION_H

#include <iostream>
#include "ArraySorter.h"

using namespace std;


class ArraySorterSelectionSort : public ArraySorter
{

public:

    ArraySorterSelectionSort();
    ArraySorterSelectionSort(int, int[]);
    virtual ~ArraySorterSelectionSort();
    virtual void launch();

private:
    int numberOfElements;
    int* tab;


};

#endif
