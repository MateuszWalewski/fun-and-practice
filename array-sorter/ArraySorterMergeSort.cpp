#include <iostream>
#include "ArraySorterMergeSort.h"

using namespace std;


ArraySorterMergeSort::ArraySorterMergeSort(int n, int t[]):numberOfElements(n),tab(t) {}

ArraySorterMergeSort::~ArraySorterMergeSort()
{

}


void ArraySorterMergeSort::launch()
{
    int start = 0;
    int last = numberOfElements-1;
    mergeSort(start, last);
}

//taken from http://www.algorytm.org/

void ArraySorterMergeSort::mergeSort(int start, int last)
{
    int middle;
    if (start != last)
    {
        middle = (start + last)/2;
        mergeSort(start, middle);
        mergeSort(middle+1, last);
        fusion(start, middle, last);
    }
}
//----------------------------------------------

//taken from http://www.algorytm.org/
void ArraySorterMergeSort::fusion(int start, int middle, int last) //auxiliary function of merge-sort algorithm
{
    int *tab_pom = new int[(last-start+1)]; // creation of auxiliary array
    int i = start, j = middle+1, k = 0; // auxiliary variables
    while (i <= middle && j <= last)
    {
        if (tab[j] < tab[i])
        {
            tab_pom[k] = tab[j];
            j++;
        }
        else
        {
            tab_pom[k] = tab[i];
            i++;
        }
        k++;
    }
    if (i <= middle)
    {
        while (i <= middle)
        {
            tab_pom[k] = tab[i];
            i++;
            k++;
        }
    }
    else
    {
        while (j <= last)
        {
            tab_pom[k] = tab[j];
            j++;
            k++;
        }
    }
    for (i = 0; i <= last-start; i++)
        tab[start+i] = tab_pom[i];

    delete [] tab_pom;
}


