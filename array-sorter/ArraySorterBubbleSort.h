#ifndef ARRAYSORTERBUBBLE_H
#define ARRAYSORTERBUBBLE_H

#include <iostream>
#include "ArraySorter.h"

using namespace std;


class ArraySorterBubbleSort : public ArraySorter
{

public:

    ArraySorterBubbleSort(int, int[]);
    virtual ~ArraySorterBubbleSort();
    virtual void launch();

private:
    int numberOfElements;
    int* tab;


};
#endif
