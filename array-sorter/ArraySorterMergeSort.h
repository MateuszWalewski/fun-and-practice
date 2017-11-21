#ifndef ARRAYSORTERMERGE_H
#define ARRAYSORTERMERGE_H

#include <iostream>
#include "ArraySorter.h"

using namespace std;


class ArraySorterMergeSort : public ArraySorter
{

public:

    ArraySorterMergeSort(int, int[]);
    virtual ~ArraySorterMergeSort();
    virtual void launch();
    void mergeSort(int, int);
    void fusion(int, int, int);

private:
    int numberOfElements;
    int* tab;


};

#endif
