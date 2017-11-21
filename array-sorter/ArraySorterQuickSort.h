#ifndef ARRAYSORTERQUICK_H
#define ARRAYSORTERQUICK_H

#include <iostream>
#include "ArraySorter.h"

using namespace std;


class ArraySorterQuickSort : public ArraySorter
{

public:

    ArraySorterQuickSort(int, int[]);
    virtual ~ArraySorterQuickSort();
    virtual void launch();
    void quicksort(int, int);

private:
    int numberOfElements;
    int* tab;


};
#endif

