#include <iostream>
#include "ArraySorterInsertionSort.h"

using namespace std;


ArraySorterInsertionSort::ArraySorterInsertionSort(int n, int t[]):numberOfElements(n),tab(t) {}
ArraySorterInsertionSort::~ArraySorterInsertionSort()
{

}

//taken from http://www.algorytm.org/
void ArraySorterInsertionSort::launch()
{
    int temp, j;
    for( int i = 1; i < numberOfElements; i++ )
    {
        temp = tab[ i ];
        for( j = i - 1; j >= 0 && tab[ j ] > temp; j-- )
        {
            tab[ j + 1 ] = tab[ j ];
        }
        tab[ j + 1 ] = temp;
    }
}

