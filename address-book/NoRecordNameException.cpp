#include "NoRecordNameException.h"

const char* NoRecordNameException::what() const throw()
{
    return "There is no contact of the given name";
}

