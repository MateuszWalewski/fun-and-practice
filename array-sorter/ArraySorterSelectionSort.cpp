#include <iostream>
#include "ArraySorterSelectionSort.h"

using namespace std;

ArraySorterSelectionSort::ArraySorterSelectionSort() {}
ArraySorterSelectionSort::ArraySorterSelectionSort(int n, int t[]):numberOfElements(n),tab(t) {}
ArraySorterSelectionSort::~ArraySorterSelectionSort()
{

}

//taken from http://www.algorytm.org/
void ArraySorterSelectionSort::launch()
{
    int j, k;
    for(int i=0; i<numberOfElements; i++)
    {
        k=i;
        for(j=i+1; j<numberOfElements; j++)
        {
            if(tab[j]<tab[k]) k=j;
        }
        swap(tab[k], tab[i]);
    }
}
